<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring;

use LauLamanApps\eCurring\Factory\SubscriptionFactoryInterface;
use LauLamanApps\eCurring\Factory\SubscriptionPlanFactoryInterface;
use LauLamanApps\eCurring\Factory\TransactionFactoryInterface;
use LauLamanApps\eCurring\Http\ClientInterface;
use LauLamanApps\eCurring\Http\Endpoint\MapperInterface;
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

    public function __construct(
        ClientInterface $httpClient,
        SubscriptionFactoryInterface $subscriptionFactory,
        SubscriptionPlanFactoryInterface $subscriptionPlanFactory,
        TransactionFactoryInterface $transactionFactory
    ) {
        $this->httpClient = $httpClient;
        $this->subscriptionFactory = $subscriptionFactory;
        $this->subscriptionPlanFactory = $subscriptionPlanFactory;
        $this->transactionFactory = $transactionFactory;
    }

    public function getCustomers(?Page $page = null): array
    {
        // TODO: Implement getCustomers() method.
    }

    public function getCustomer(string $id): Customer
    {
        // TODO: Implement getCustomer() method.
    }

    public function createCustomer(Customer $customer): Customer
    {
        // TODO: Implement createCustomer() method.
    }

    public function updateCustomer(Customer $customer): Customer
    {
        // TODO: Implement updateCustomer() method.
    }

    public function getSubscriptionPlans(?Page $page = null): SubscriptionPlanCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_PLANS, [], $page)
        );

        return $this->subscriptionPlanFactory->fromArray(
            $this,
            $this->decodeJsonToArray($json),
            $page ?? new Page(10)
        );
    }

    public function getSubscriptionPlan(string $id): SubscriptionPlan
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_PLAN, [$id])
        );

        return $this->subscriptionPlanFactory->fromData($this, $this->decodeJsonToArray($json));
    }

    public function getSubscriptions(?Page $page = null): SubscriptionCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTIONS)
        );

        return $this->subscriptionFactory->fromArray(
            $this,
            $this->decodeJsonToArray($json),
            $page ?? new Page(10)
        );
    }

    public function getSubscription(string $id): Subscription
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION, [$id])
        );

        return $this->subscriptionFactory->fromData($this, $this->decodeJsonToArray($json));
    }

    public function getSubscriptionTransactions(Subscription $subscription, ?Page $page = null): SubscriptionTransactionCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_TRANSACTIONS, [$subscription->getId()])
        );

        return $this->transactionFactory->fromSubscriptionArray(
            $this,
            $this->decodeJsonToArray($json),
            $page ?? new Page(10)
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

    public function getTransactions(?Page $page = null): TransactionCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_TRANSACTIONS)
        );

        return $this->transactionFactory->fromArray(
            $this,
            $this->decodeJsonToArray($json),
            $page ?? new Page(10)
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
        // TODO: Implement deleteTransaction() method.
    }

    private function decodeJsonToArray(string $json): array
    {
        return json_decode($json, true);
    }
}
