<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Proxy;

use DateTimeImmutable;
use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\CustomerInterface;
use LauLamanApps\eCurring\Resource\ProductInterface;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\Subscription\Mandate;
use LauLamanApps\eCurring\Resource\Subscription\Status;
use LauLamanApps\eCurring\Resource\SubscriptionInterface;
use LauLamanApps\eCurring\Resource\TransactionInterface;

/**
 * @method int getId()
 * @method Mandate getMandate()
 * @method DateTimeImmutable getStartDate()
 * @method Status getStatus()
 * @method DateTimeImmutable|null getCancelDate()
 * @method DateTimeImmutable|null getResumeDate()
 * @method string getConfirmationPage()
 * @method bool isConfirmationSent()
 * @method string|null getSubscriptionWebhookUrl()
 * @method string|null getTransactionWebhookUrl()
 * @method string|null getSuccessRedirectUrl()
 * @method ProductInterface getSubscriptionPlan()
 * @method CustomerInterface getCustomer()
 * @method TransactionInterface[]|null getTransactions()
 * @method DateTimeImmutable getCreatedAt()
 * @method DateTimeImmutable getUpdatedAt()
 */
final class SubscriptionProxy extends AbstractProxy implements SubscriptionInterface
{
    /**
     * @return Subscription
     */
    protected function __load(eCurringClientInterface $client, string $id)
    {
        return $client->getSubscription($id);
    }
}
