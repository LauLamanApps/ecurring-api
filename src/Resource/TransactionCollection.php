<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource;

use LauLamanApps\eCurring\Resource\Curser\Page;

/**
 * @method Transaction[] getAll()
 * @method Transaction current()
 */
final class TransactionCollection extends Cursor
{
    protected function loadPage(int $number, int $itemsPerPage): array
    {
        $cursor = $this->client->getSubscriptionPlans(new Page($itemsPerPage, $number));

        return $cursor->getAll();
    }
}
