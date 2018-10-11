<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Factory;

use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Curser\Page;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\SubscriptionTransactionCollection;
use LauLamanApps\eCurring\Resource\Transaction;
use LauLamanApps\eCurring\Resource\TransactionCollection;

interface TransactionFactoryInterface
{
    public function fromData(array $data): Transaction;

    /**
     * @return Transaction[]
     */
    public function fromArray(eCurringClientInterface $client, array $data, Page $page): TransactionCollection;

    public function fromSubscriptionArray(
        eCurringClientInterface $client,
        array $data,
        Subscription $subscription,
        Page $page
    ): SubscriptionTransactionCollection;
}
