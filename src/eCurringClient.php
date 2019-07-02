<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring;

use LauLamanApps\eCurring\Http\ClientInterface;
use LauLamanApps\eCurring\Http\Endpoint\MapperInterface;
use LauLamanApps\eCurring\Http\Resource\Creatable;
use LauLamanApps\eCurring\Http\Resource\CreateParserInterface;
use LauLamanApps\eCurring\Http\Resource\Deletable;
use LauLamanApps\eCurring\Http\Resource\Updatable;
use LauLamanApps\eCurring\Http\Resource\UpdateParserInterface;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\Customer;
use LauLamanApps\eCurring\Resource\CustomerCollection;
use LauLamanApps\eCurring\Resource\Factory\CustomerFactoryInterface;
use LauLamanApps\eCurring\Resource\Factory\ProductFactoryInterface;
use LauLamanApps\eCurring\Resource\Factory\SubscriptionFactoryInterface;
use LauLamanApps\eCurring\Resource\Factory\TransactionFactoryInterface;
use LauLamanApps\eCurring\Resource\Product;
use LauLamanApps\eCurring\Resource\ProductCollection;
use LauLamanApps\eCurring\Resource\Subscription;
use LauLamanApps\eCurring\Resource\SubscriptionCollection;
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
     * @var ProductFactoryInterface
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

    /**
     * @var CreateParserInterface
     */
    private $createParser;

    /**
     * @var UpdateParserInterface
     */
    private $updateParser;

    public function __construct(
        ClientInterface $httpClient,
        CustomerFactoryInterface $customerFactory,
        SubscriptionFactoryInterface $subscriptionFactory,
        ProductFactoryInterface $subscriptionPlanFactory,
        TransactionFactoryInterface $transactionFactory,
        CreateParserInterface $createParser,
        UpdateParserInterface $updateParser
    ) {
        $this->httpClient = $httpClient;
        $this->customerFactory = $customerFactory;
        $this->subscriptionFactory = $subscriptionFactory;
        $this->subscriptionPlanFactory = $subscriptionPlanFactory;
        $this->transactionFactory = $transactionFactory;
        $this->createParser = $createParser;
        $this->updateParser = $updateParser;
    }

    public function create(Creatable $entity): Creatable
    {
        switch (true) {
            case $entity instanceof Customer:
                return $this->createCustomer($entity);
            case $entity instanceof Subscription:
                return $this->createSubscription($entity);
            case $entity instanceof Transaction:
                return $this->createTransaction($entity);
        }
    }

    public function update(Updatable $entity): Updatable
    {
        switch (true) {
            case $entity instanceof Customer:
                return $this->updateCustomer($entity);
            case $entity instanceof Subscription:
                return $this->updateSubscription($entity);
        }
    }

    public function delete(Deletable $entity): void
    {
        switch (true) {
            case $entity instanceof Transaction:
                $this->deleteTransaction($entity);
        }
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

        return $this->customerFactory->fromData($this, $this->decodeJsonToArray($json)['data']);
    }

    public function getProducts(?Pagination $pagination = null): ProductCollection
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

    public function getProduct(string $id): Product
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_PLAN, [$id])
        );

        return $this->subscriptionPlanFactory->fromData($this, $this->decodeJsonToArray($json)['data']);
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

        return $this->subscriptionFactory->fromData($this, $this->decodeJsonToArray($json)['data']);
    }

    public function getSubscriptionTransactions(Subscription $subscription, ?Pagination $pagination = null): TransactionCollection
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_SUBSCRIPTION_TRANSACTIONS, [$subscription->getId()])
        );

        return $this->transactionFactory->fromSubscriptionArray(
            $this,
            $this->decodeJsonToArray($json),
            $subscription,
            $pagination ?? new Pagination(10)
        );
    }

    /**
     * @param UuidInterface $id
     * @return Transaction
     * @throws Http\Exception\ApiCallException
     */
    public function getTransaction(UuidInterface $id): Transaction
    {
        $json = $this->httpClient->getJson(
            $this->httpClient->getEndpoint(MapperInterface::GET_TRANSACTION, [$id])
        );

        return $this->transactionFactory->fromData($this->decodeJsonToArray($json)['data']);
    }

    private function createCustomer(Customer $customer): Customer
    {
        $data = $this->createParser->parse($customer);
        
        $json = $this->httpClient->getJson(
            $this->httpClient->postEndpoint(MapperInterface::POST_CUSTOMER, $data)
        );

        return $this->customerFactory->fromData($this, $this->decodeJsonToArray($json)['data']);
    }
    private function updateCustomer(Customer $customer): Customer
    {
        $data = $this->updateParser->parse($customer);

        $json = $this->httpClient->getJson(
            $this->httpClient->patchEndpoint(MapperInterface::PATCH_CUSTOMER, $data, [$customer->getId()])
        );

        return $this->customerFactory->fromData($this, $this->decodeJsonToArray($json));
    }
    private function createSubscription(Subscription $subscription): Subscription
    {
        $data = $this->createParser->parse($subscription);

        $json = $this->httpClient->getJson(
            $this->httpClient->postEndpoint(MapperInterface::POST_SUBSCRIPTION, $data)
        );

        return $this->subscriptionFactory->fromData($this, $this->decodeJsonToArray($json)['data']);
    }

    private function updateSubscription(Subscription $subscription): Subscription
    {
        $data = $this->updateParser->parse($subscription);

        $json = $this->httpClient->getJson(
            $this->httpClient->patchEndpoint(MapperInterface::PATCH_SUBSCRIPTION, $data, [$subscription->getId()])
        );

        return $this->subscriptionFactory->fromData($this, $this->decodeJsonToArray($json)['data']);
    }

    private function createTransaction(Transaction $transaction): Transaction
    {
        $data = $this->createParser->parse($transaction);

        $json = $this->httpClient->getJson(
            $this->httpClient->postEndpoint(MapperInterface::POST_TRANSACTION, $data)
        );

        return $this->transactionFactory->fromData($this, $this->decodeJsonToArray($json)['data']);
    }

    private function deleteTransaction(Transaction $transaction): void
    {
        $this->httpClient->deleteEndpoint(MapperInterface::DELETE_TRANSACTION, [$transaction->getId()]);
    }

    private function decodeJsonToArray(string $json): array
    {
        return json_decode($json, true);
    }
}
