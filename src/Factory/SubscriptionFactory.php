<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Factory;

use DateTimeImmutable;
use InvalidArgumentException;
use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Curser\Page;
use LauLamanApps\eCurring\Resource\Proxy\CustomerProxy;
use LauLamanApps\eCurring\Resource\Proxy\SubscriptionPlanProxy;
use LauLamanApps\eCurring\Resource\Proxy\TransactionProxy;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\Subscription\Mandate;
use LauLamanApps\eCurring\Resource\Subscription\Status;
use LauLamanApps\eCurring\Resource\SubscriptionCollection;

final class SubscriptionFactory extends AbstractFactory implements SubscriptionFactoryInterface
{
    public function fromArray(eCurringClientInterface $client, array $data, Page $page): SubscriptionCollection
    {
        $subscriptions = [];
        foreach ($data['data'] as $data) {
            $subscriptions[] = $this->fromData($data);
        }
        $totalPages = $this->extractInteger('total', $data['meta']);

        return new SubscriptionCollection($client, $page->getNumber(), $totalPages, $subscriptions);
    }

    public function fromData(eCurringClientInterface $client, array $data): Subscription
    {
        return Subscription::fromData(
            $this->extractInteger('id', $data),
            $this->getMandate($data['attributes']),
            new DateTimeImmutable($data['attributes']['start_date']),
            Status::get($data['attributes']['status']),
            $data['attributes']['confirmation_page'],
            $this->extractBoolean('confirmation_sent', $data),
            $this->getCustomerProxy($client, $data['relationships']),
            $this->getSubscriptionPlanProxy($client, $data['relationships']),
            new DateTimeImmutable($data['attributes']['created_at']),
            new DateTimeImmutable($data['attributes']['updated_at']),
            $this->extractStringOrNull('subscription_webhook_url', $data['attributes']),
            $this->extractStringOrNull('transaction_webhook_url', $data['attributes']),
            $this->extractStringOrNull('success_redirect_url', $data['attributes']),
            $this->extractDateTimeImmutableOrNull('cancel_date', $data['attributes']),
            $this->extractDateTimeImmutableOrNull('resume_date', $data['attributes']),
            ...$this->getTransactionProxies($client, $data['relationships'])
        );
    }

    private function getMandate(array $data): Mandate
    {
        return new Mandate(
            $data['mandate_code'],
            $this->extractBoolean('mandate_accepted', $data),
            new DateTimeImmutable($data['mandate_accepted_date'])
        );
    }

    private function getSubscriptionPlanProxy(eCurringClientInterface $client, array $relationships): SubscriptionPlanProxy
    {
        if (!isset($relationships['subscription-plan'])) {
            throw new InvalidArgumentException('customer not found in data');
        }

        return new SubscriptionPlanProxy($client, $relationships['subscription-plan']['data']['id']);
    }

    private function getCustomerProxy(eCurringClientInterface $client, array $relationships): CustomerProxy
    {
        if (!isset($relationships['customer'])) {
            throw new InvalidArgumentException('customer not found in data');
        }

        return new CustomerProxy($client, $relationships['customer']['data']['id']);
    }

    /**
     * @return TransactionProxy[]
     */
    private function getTransactionProxies(eCurringClientInterface $client, array $transactions): array
    {
        if (!isset($transactions['transactions'])) {
            return [];
        }

        $subscriptions = [];

        foreach ($transactions['transactions']['data'] as $subscription) {
            if ($subscription['type'] !== 'transaction') {
                continue;
            }

            $subscriptions[] = new TransactionProxy($client, $subscription['id']);
        }

        return $subscriptions;
    }
}
