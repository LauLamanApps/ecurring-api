<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Proxy;

use DateTimeImmutable;
use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Transaction;
use LauLamanApps\eCurring\Resource\Transaction\Event;
use LauLamanApps\eCurring\Resource\Transaction\PaymentMethod;
use LauLamanApps\eCurring\Resource\Transaction\Status;
use LauLamanApps\eCurring\Resource\TransactionInterface;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @method UuidInterface|null getId()
 * @method Status|null getStatus()
 * @method DateTimeImmutable|null getScheduledOn()
 * @method DateTimeImmutable|null getDueDate()
 * @method Money getAmount()
 * @method DateTimeImmutable|null getCanceledOn()
 * @method string|null getWebhookUrl()
 * @method PaymentMethod getPaymentMethod()
 * @method Event[] getHistory()
 */
final class TransactionProxy extends AbstractProxy implements TransactionInterface
{
    /**
     * @return Transaction
     */
    protected function __load(eCurringClientInterface $client, string $id)
    {
        return $client->getTransaction(Uuid::fromString($id));
    }
}
