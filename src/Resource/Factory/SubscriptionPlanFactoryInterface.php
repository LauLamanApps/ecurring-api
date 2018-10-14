<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Factory;

use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\SubscriptionPlan;
use LauLamanApps\eCurring\Resource\SubscriptionPlanCollection;

interface SubscriptionPlanFactoryInterface
{
    public function fromData(eCurringClientInterface $client, array $data): SubscriptionPlan;

    /**
     * @return SubscriptionPlan[]
     */
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): SubscriptionPlanCollection;
}
