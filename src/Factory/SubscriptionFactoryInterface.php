<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Factory;

use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Curser\Page;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\SubscriptionCollection;

interface SubscriptionFactoryInterface
{
    public function fromData(eCurringClientInterface $client, array $data): Subscription;

    /**
     * @return Subscription[]
     */
    public function fromArray(eCurringClientInterface $client, array $data, Page $page): SubscriptionCollection;
}
