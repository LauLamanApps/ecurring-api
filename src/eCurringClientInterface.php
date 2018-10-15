<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring;

use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\Customer;
use LauLamanApps\eCurring\Resource\CustomerCollection;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\SubscriptionCollection;
use LauLamanApps\eCurring\Resource\SubscriptionPlan;
use LauLamanApps\eCurring\Resource\SubscriptionPlanCollection;
use LauLamanApps\eCurring\Resource\Transaction;
use LauLamanApps\eCurring\Resource\TransactionCollection;
use Ramsey\Uuid\UuidInterface;

interface eCurringClientInterface
{
    /**
     * @return Customer[]
     */
    public function getCustomers(?Pagination $pagination = null): CustomerCollection;

    public function getCustomer(string $id): Customer;

    public function createCustomer(Customer $customer): Customer;

    public function updateCustomer(Customer $customer): Customer;

    /**
     * @return SubscriptionPlan[]
     */
    public function getSubscriptionPlans(?Pagination $pagination = null): SubscriptionPlanCollection;

    public function getSubscriptionPlan(string $id): SubscriptionPlan;

    /**
     * @return Subscription[]
     */
    public function getSubscriptions(?Pagination $page = null): SubscriptionCollection;

    public function getSubscription(string $id): Subscription;

    /**
     * @return Transaction[]
     */
    public function getSubscriptionTransactions(Subscription $subscription, ?Pagination $pagination = null): TransactionCollection;

    public function createSubscription(Subscription $subscription): Subscription;

    public function updateSubscription(Subscription $subscription): Subscription;

    public function getTransaction(UuidInterface $id): Transaction;

    public function createTransaction(Transaction $transaction): Transaction;

    public function deleteTransaction(Transaction $transaction): void;
}
