<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource;

use LauLamanApps\eCurring\Resource\Curser\Pagination;

/**
 * @method Product[] getAll()
 * @method Product current()
 */
final class ProductCollection extends Cursor
{
    protected function getPageData(int $pageNumber, int $itemsPerPage): Cursor
    {
        return $this->client->getProducts(new Pagination($itemsPerPage, $pageNumber));
    }
}
