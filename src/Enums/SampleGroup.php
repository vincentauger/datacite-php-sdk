<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

enum SampleGroup: string
{
    case CLIENT = 'client';
    case PROVIDER = 'provider';
    case RESOURCE_TYPE = 'resource-type';
}
