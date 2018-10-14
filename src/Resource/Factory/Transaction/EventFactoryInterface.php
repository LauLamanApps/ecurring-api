<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource\Factory\Transaction;

use LauLamanApps\eCurring\Resource\Transaction\Event;

interface EventFactoryInterface
{
    /**
     * @return Event[]
     */
    public function fromArray(array $data): ?array;
}
