<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Tests\Unit\_helpers;

use DateTime;
use DateTimeInterface;

trait AssertionTrait
{
    public static function assertDateTimeOrNull(?string $data, ?DateTimeInterface $actual): void
    {
        if ($data !== null) {
            self::assertSame($data, $actual->format(DateTime::ATOM));
        } else {
            self::assertNull($actual);
        }
    }

    public static function assertStringOrNull(?string $data, ?string $actual): void
    {
        if ($data !== null) {
            self::assertSame($data, $actual);
        } else {
            self::assertNull($actual);
        }
    }
}
