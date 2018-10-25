<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring;

use LauLamanApps\eCurring\Http\Resource\Creatable;
use LauLamanApps\eCurring\Http\Resource\Deletable;
use LauLamanApps\eCurring\Http\Resource\Updatable;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\Customer;
use LauLamanApps\eCurring\Resource\CustomerCollection;
use LauLamanApps\eCurring\Resource\Product;
use LauLamanApps\eCurring\Resource\ProductCollection;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\SubscriptionCollection;
use LauLamanApps\eCurring\Resource\Transaction;
use LauLamanApps\eCurring\Resource\TransactionCollection;
use Ramsey\Uuid\UuidInterface;

interface eCurringClientInterface
{

    /**
     * @return Customer|Subscription|Transaction
     */
    public function create(Creatable $entity): Creatable;

    /**
     * @return Customer|Subscription
     */
    public function update(Updatable $entity): Updatable;

    public function delete(Deletable $entity): void;

    /**
     * @return Customer[]
     */
    public function getCustomers(?Pagination $pagination = null): CustomerCollection;

    public function getCustomer(string $id): Customer;

    /**
     * @return Product[]
     */
    public function getProducts(?Pagination $pagination = null): ProductCollection;

    public function getProduct(string $id): Product;

    /**
     * @return Subscription[]
     */
    public function getSubscriptions(?Pagination $page = null): SubscriptionCollection;

    public function getSubscription(string $id): Subscription;

    /**
     * @return Transaction[]
     */
    public function getSubscriptionTransactions(Subscription $subscription, ?Pagination $pagination = null): TransactionCollection;

    public function getTransaction(UuidInterface $id): Transaction;
}
