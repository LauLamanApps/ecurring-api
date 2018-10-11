<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring;

use LauLamanApps\eCurring\Resource\Curser\Page;
use LauLamanApps\eCurring\Resource\Customer;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\SubscriptionCollection;
use LauLamanApps\eCurring\Resource\SubscriptionPlan;
use LauLamanApps\eCurring\Resource\SubscriptionPlanCollection;
use LauLamanApps\eCurring\Resource\SubscriptionTransactionCollection;
use LauLamanApps\eCurring\Resource\Transaction;
use LauLamanApps\eCurring\Resource\TransactionCollection;
use Ramsey\Uuid\UuidInterface;

interface eCurringClientInterface
{
    /**
     * @return Customer[]
     */
    public function getCustomers(?Page $page = null): array;

    public function getCustomer(string $id): Customer;

    public function createCustomer(Customer $customer): Customer;

    public function updateCustomer(Customer $customer): Customer;

    /**
     * @return SubscriptionPlan[]
     */
    public function getSubscriptionPlans(?Page $page = null): SubscriptionPlanCollection;

    public function getSubscriptionPlan(string $id): SubscriptionPlan;

    /**
     * @return Subscription[]
     */
    public function getSubscriptions(?Page $page = null): SubscriptionCollection;

    public function getSubscription(string $id): Subscription;

    /**
     * @return Transaction[]
     */
    public function getSubscriptionTransactions(Subscription $subscription, ?Page $page = null): SubscriptionTransactionCollection;

    public function createSubscription(Subscription $subscription): Subscription;

    public function updateSubscription(Subscription $subscription): Subscription;

    /**
     * @return Transaction[]
     */
    public function getTransactions(?Page $page = null): TransactionCollection;

    public function getTransaction(UuidInterface $id): Transaction;

    public function createTransaction(Transaction $transaction): Transaction;

    public function deleteTransaction(Transaction $transaction): void;
}
