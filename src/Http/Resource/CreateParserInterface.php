<?php

declare(strict_types=1);

namespace LauLamanApps\eCurring\Http\Resource;

interface CreateParserInterface
{
    public function parse(Creatable $object): array;
}
