<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Proxy;

use DateTimeImmutable;
use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Product;
use LauLamanApps\eCurring\Resource\Product\AuthenticationMethod;
use LauLamanApps\eCurring\Resource\Product\Status;
use LauLamanApps\eCurring\Resource\ProductInterface;
use LauLamanApps\eCurring\Resource\SubscriptionInterface;

/**
 * @method int getId()
 * @method string getName()
 * @method string getDescription()
 * @method DateTimeImmutable getStartDate()
 * @method Status getStatus()
 * @method AuthenticationMethod getMandateAuthenticationMethod()
 * @method bool isSendInvoice()
 * @method int getStornoRetries()
 * @method string|null getTerms()
 * @method SubscriptionInterface[] getSubscriptions()
 * @method DateTimeImmutable getCreatedAt()
 * @method DateTimeImmutable getUpdatedAt()
 */
final class ProductProxy extends AbstractProxy implements ProductInterface
{
    /**
     * @return Product
     */
    protected function __load(eCurringClientInterface $client, string $id)
    {
        return $client->getProduct($id);
    }
}
