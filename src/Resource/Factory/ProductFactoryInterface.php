<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Factory;

use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\Product;
use LauLamanApps\eCurring\Resource\ProductCollection;

interface ProductFactoryInterface
{
    public function fromData(eCurringClientInterface $client, array $data): Product;

    /**
     * @return Product[]
     */
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): ProductCollection;
}
