<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource;

use DateTimeImmutable;
use LauLamanApps\eCurring\Resource\SubscriptionPlan\AuthenticationMethod;
use LauLamanApps\eCurring\Resource\SubscriptionPlan\Status;

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
interface SubscriptionPlanInterface
{
}
