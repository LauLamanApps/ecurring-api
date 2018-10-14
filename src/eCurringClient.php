<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring;

use LauLamanApps\eCurring\Http\ClientInterface;
use LauLamanApps\eCurring\Http\Endpoint\MapperInterface;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\Customer;
use LauLamanApps\eCurring\Resource\CustomerCollection;
use LauLamanApps\eCurring\Resource\Factory\CustomerFactoryInterface;
use LauLamanApps\eCurring\Resource\Factory\SubscriptionFactoryInterface;
use LauLamanApps\eCurring\Resource\Factory\SubscriptionPlanFactoryInterface;
use LauLamanApps\eCurring\Resource\Factory\TransactionFactoryInterface;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\SubscriptionCollection;
use LauLamanApps\eCurring\Resource\SubscriptionPlan;
use LauLamanApps\eCurring\Resource\SubscriptionPlanCollection;
use LauLamanApps\eCurring\Resource\SubscriptionTransactionCollection;
use LauLamanApps\eCurring\Resource\Transaction;
use LauLamanApps\eCurring\Resource\TransactionCollection;
use Ramsey\Uuid\UuidInterface;

final class eCurringClient implements eCurringClientInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var SubscriptionPlanFactoryInterface
     */
    private $subscriptionPlanFactory;

    /**
     * @var TransactionFactoryInterface
     */
    private $transactionFactory;
    /**
     * @var SubscriptionFactoryInterface
     */
    private $subscriptionFactory;
    /**
     * @var CustomerFactoryInterface
     */
    private $customerFactory;

    public function __construct(
        ClientInterface $httpClient,
        CustomerFactoryInterface $customerFactory,
        SubscriptionFactoryInterface $subscriptionFactory,
        SubscriptionPlanFactoryInterface $subscriptionPlanFactory,
        TransactionFactoryInterface $transactionFactory
    ) {
        $this->httpClient = $httpClient;
        $this->customerFactory = $customerFactory;
        $this->subscriptionFactory = $subscriptionFactory;
        $this->subscriptionPlanFactory = $subscriptionPlanFactory;
        $this->transactionFactory = $transactionFactory;
    }

    public function getCustomers(?Pagination $pagination = null): CustomerCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_CUSTOMERS, [], $pagination)
        );

        return $this->customerFactory->fromArray(
            $this,
            $this->decodeJsonToArray($json),
            $pagination ?? new Pagination(10)
        );
    }

    public function getCustomer(string $id): Customer
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_CUSTOMER, [$id])
        );

        return $this->customerFactory->fromData($this, $this->decodeJsonToArray($json));
    }

    public function createCustomer(Customer $customer): Customer
    {
        // TODO: Implement createCustomer() method.
    }

    public function updateCustomer(Customer $customer): Customer
    {
        // TODO: Implement updateCustomer() method.
    }

    public function getSubscriptionPlans(?Pagination $pagination = null): SubscriptionPlanCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_PLANS, [], $pagination)
        );

        return $this->subscriptionPlanFactory->fromArray(
            $this,
            $this->decodeJsonToArray($json),
            $pagination ?? new Pagination(10)
        );
    }

    public function getSubscriptionPlan(string $id): SubscriptionPlan
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_PLAN, [$id])
        );

        return $this->subscriptionPlanFactory->fromData($this, $this->decodeJsonToArray($json));
    }

    public function getSubscriptions(?Pagination $page = null): SubscriptionCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTIONS)
        );

        return $this->subscriptionFactory->fromArray(
            $this,
            $this->decodeJsonToArray($json),
            $page ?? new Pagination(10)
        );
    }

    public function getSubscription(string $id): Subscription
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION, [$id])
        );

        return $this->subscriptionFactory->fromData($this, $this->decodeJsonToArray($json));
    }

    public function getSubscriptionTransactions(Subscription $subscription, ?Pagination $pagination = null): SubscriptionTransactionCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_TRANSACTIONS, [$subscription->getId()])
        );

        return $this->transactionFactory->fromSubscriptionArray(
            $this,
            $this->decodeJsonToArray($json),
            $pagination ?? new Pagination(10)
        );
    }

    public function createSubscription(Subscription $subscription): Subscription
    {
        // TODO: Implement createSubscription() method.
    }

    public function updateSubscription(Subscription $subscription): Subscription
    {
        // TODO: Implement updateSubscription() method.
    }

    public function getTransactions(?Pagination $pagination = null): TransactionCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_TRANSACTIONS)
        );

        return $this->transactionFactory->fromArray(
            $this,
            $this->decodeJsonToArray($json),
            $pagination ?? new Pagination(10)
        );
    }

    public function getTransaction(UuidInterface $id): Transaction
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_PLAN, [$id])
        );

        return $this->transactionFactory->fromData($this->decodeJsonToArray($json));
    }

    public function createTransaction(Transaction $transaction): Transaction
    {
        // TODO: Implement createTransaction() method.
    }

    public function deleteTransaction(Transaction $transaction): void
    {
        $this->httpClient->deleteEndpoint(MapperInterface::DELETE_TRANSACTION, [$transaction->getId()]);
    }

    private function decodeJsonToArray(string $json): array
    {
        return json_decode($json, true);
    }
}
