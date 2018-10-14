<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource;

use LauLamanApps\eCurring\Resource\Curser\Pagination;

/**
 * @method Transaction[] getAll()
 * @method Transaction current()
 */
final class TransactionCollection extends Cursor
{
    protected function getPageData(int $pageNumber, int $itemsPerPage): Cursor
    {
        return $this->client->getSubscriptionPlans(new Pagination($itemsPerPage, $pageNumber));
    }
}
