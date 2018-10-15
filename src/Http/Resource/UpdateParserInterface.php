<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Http\Resource;

interface UpdateParserInterface
{
    public function parse(Updatable $object): array;
}
