<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Factory;

use LauLamanApps\eCurring\eCurringClientInterface;
use LauLamanApps\eCurring\Resource\Curser\Pagination;
use LauLamanApps\eCurring\Resource\Customer;
use LauLamanApps\eCurring\Resource\CustomerCollection;

interface CustomerFactoryInterface
{
    public function fromData(eCurringClientInterface $client, array $data): Customer;

    /**
     * @return Customer[]
     */
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): CustomerCollection;
}
