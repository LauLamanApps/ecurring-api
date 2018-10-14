<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Factory;

use DateTimeImmutable;
use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\Proxy\SubscriptionProxy;
use LauLamanApps\eCurring\Resource\SubscriptionPlan;
use LauLamanApps\eCurring\Resource\SubscriptionPlan\AuthenticationMethod;
use LauLamanApps\eCurring\Resource\SubscriptionPlan\Status;
use LauLamanApps\eCurring\Resource\SubscriptionPlanCollection;

final class SubscriptionPlanFactory extends AbstractFactory implements SubscriptionPlanFactoryInterface
{
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): SubscriptionPlanCollection
    {
        $transactions = [];
        foreach ($data['data'] as $data) {
            $transactions[] = $this->fromData($client, $data);
        }

        $totalPages = $data['meta']['total'];

        return new SubscriptionPlanCollection($client, $page->getNumber(), $totalPages ?? 1, $transactions, $page->getSize());
    }

    public function fromData(eCurringClientInterface $client, array $data): SubscriptionPlan
    {
        return new SubscriptionPlan(
            $this->extractInteger('id', $data),
            $data['attributes']['name'],
            $data['attributes']['description'],
            new DateTimeImmutable($data['attributes']['start_date']),
            Status::get($data['attributes']['status']),
            AuthenticationMethod::get($data['attributes']['mandate_authentication_method']),
            $this->extractBoolean('send_invoice', $data['attributes']),
            $this->extractInteger('storno_retries', $data['attributes']),
            new DateTimeImmutable($data['attributes']['created_at']),
            new DateTimeImmutable($data['attributes']['updated_at']),
            $this->extractStringOrNull('terms', $data['attributes']),
            ...$this->getSubscriptionProxies($client, $data['relationships'])
        );
    }

    /**
     * @return SubscriptionProxy[]
     */
    private function getSubscriptionProxies(eCurringClientInterface $client, array $relationships): array
    {
        if (!isset($relationships['subscriptions'])) {
            return [];
        }

        $subscriptions = [];

        foreach ($relationships['subscriptions']['data'] as $subscription) {
            if ($subscription['type']  !== 'subscription') {
                continue;
            }

            $subscriptions[] = new SubscriptionProxy($client, $subscription['id']);
        }

        return $subscriptions;
    }
}
