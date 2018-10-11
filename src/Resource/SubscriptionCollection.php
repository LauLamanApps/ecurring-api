<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Resource;

use LauLamanApps\eCurring\Resource\Curser\Page;

/**
 * @method Subscription[] getAll()
 * @method Subscription current()
 */
final class SubscriptionCollection extends Cursor
{
    protected function loadPage(int $number, int $itemsPerPage): array
    {
        $cursor = $this->client->getSubscriptions(new Page($itemsPerPage, $number));

        return $cursor->getAll();
    }
}
