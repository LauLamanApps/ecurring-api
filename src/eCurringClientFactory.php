<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring;

use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use LauLamanApps\eCurring\Resource\Factory\SubscriptionFactory;
use LauLamanApps\eCurring\Resource\Factory\SubscriptionPlanFactory;
use LauLamanApps\eCurring\Resource\Factory\Transaction\EventFactory;
use LauLamanApps\eCurring\Resource\Factory\TransactionFactory;
use LauLamanApps\eCurring\Http\Adapter\Guzzle\Client as GuzzleClient;
use LauLamanApps\eCurring\Http\ClientInterface;
use LauLamanApps\eCurring\Http\Endpoint\Production;
use Psr\Http\Message\RequestInterface;

final class eCurringClientFactory
{
    public static function create(string $apiKey): eCurringClient
    {
        return new eCurringClient(
            self::createHttpClient($apiKey),
            new SubscriptionFactory(),
            new SubscriptionPlanFactory(),
            new TransactionFactory(new EventFactory())
        );
    }

    private static function createHttpClient(string $apiKey): ClientInterface
    {
        $handler = new HandlerStack();
        $handler->setHandler(new CurlHandler());

        $handler->push(Middleware::mapRequest(function (RequestInterface $request) use ($apiKey) {
            return $request->withHeader('X-Authorization', $apiKey);
        }));

        return new GuzzleClient(
            new \GuzzleHttp\Client(['handler' => $handler]),
            new Production()
        );
    }
}
