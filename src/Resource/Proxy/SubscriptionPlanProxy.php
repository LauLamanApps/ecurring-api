<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Proxy;

use DateTimeImmutable;
use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\SubscriptionInterface;
use LauLamanApps\eCurring\Resource\SubscriptionPlan;
use LauLamanApps\eCurring\Resource\SubscriptionPlan\AuthenticationMethod;
use LauLamanApps\eCurring\Resource\SubscriptionPlan\Status;
use LauLamanApps\eCurring\Resource\SubscriptionPlanInterface;

/**
 * @method int getId()
 * @method string getName()
 * @method string getDescription()
 * @method DateTimeImmutable getStartDate()
 * @method Status getStatus()
 * @method AuthenticationMethod getMandateAuthenticationMethod()
 * @method bool isSendInvoice()
 * @method int getStornoRetries()
 * @method string|null getTerms()
 * @method SubscriptionInterface[] getSubscriptions()
 * @method DateTimeImmutable getCreatedAt()
 * @method DateTimeImmutable getUpdatedAt()
 */
final class SubscriptionPlanProxy extends AbstractProxy implements SubscriptionPlanInterface
{
    /**
     * @return SubscriptionPlan
     */
    protected function __load(eCurringClientInterface $client, string $id)
    {
        return $client->getSubscriptionPlan($id);
    }
}
