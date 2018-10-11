<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Http\Adapter\Guzzle\Exception;

use GuzzleHttp\Exception\RequestException;
use LauLamanApps\eCurring\Exception\eCurringException;

final class Handler
{
    /**
     * @throws eCurringException
     * @throws NotFoundException
     */
    public static function handleRequestException(RequestException $exception): void
    {
        switch ($exception->getCode()) {
            case 404:
                throw new NotFoundException();
        }

        throw new eCurringException($exception->getMessage());
    }
}
