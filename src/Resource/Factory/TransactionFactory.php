<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Factory;

use DateTimeImmutable;
use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Factory\Transaction\EventFactoryInterface;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\SubscriptionTransactionCollection;
use LauLamanApps\eCurring\Resource\Transaction;
use LauLamanApps\eCurring\Resource\Transaction\PaymentMethod;
use LauLamanApps\eCurring\Resource\Transaction\Status;
use LauLamanApps\eCurring\Resource\TransactionCollection;
use Money\Money;
use Ramsey\Uuid\Uuid;

final class TransactionFactory extends AbstractFactory implements TransactionFactoryInterface
{
    /**
     * @var EventFactoryInterface
     */
    private $eventFactory;

    public function __construct(EventFactoryInterface $eventFactory)
    {
        $this->eventFactory = $eventFactory;
    }

    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): TransactionCollection
    {
        $transactions = [];
        foreach ($data['data'] as $data) {
            $transactions[] = $this->fromData($data);
        }
        $totalPages = $this->extractInteger('total', $data['meta']);

        return new TransactionCollection($client, $page->getNumber(), $totalPages, $transactions);
    }

    public function fromSubscriptionArray(eCurringClientInterface $client, array $data, Subscription $subscription, Pagination $page): SubscriptionTransactionCollection
    {
        $transactions = [];
        foreach ($data['data'] as $data) {
            $transactions[] = $this->fromData($data);
        }
        $totalPages = $this->extractInteger('total', $data['meta']);

        return new SubscriptionTransactionCollection($subscription, $client, $page->getNumber(), $totalPages, $transactions);
    }

    public function fromData(array $data): Transaction
    {
        return Transaction::fromData(
            Uuid::fromString($data['id']),
            Status::get($data['attributes']['status']),
            new DateTimeImmutable($data['attributes']['scheduled_on']),
            Money::EUR($this->extractFloat('amount', $data['attributes'])*100),
            PaymentMethod::get($data['attributes']['payment_method']),
            $this->extractDateTimeImmutableOrNull('due_date', $data['attributes']),
            $this->extractDateTimeImmutableOrNull('canceled_on', $data['attributes']),
            $this->extractStringOrNull('webhook_url', $data['attributes']),
            ...$this->eventFactory->fromArray($data['attributes']['history'])
        );
    }
}
