<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * Sort options for DataCite Event Data queries.
 *
 * @see https://support.datacite.org/docs/eventdata-guide#sorting
 */
enum EventSortOption: string
{
    case RELEVANCE = 'relevance';
    case OBJ_ID = 'obj-id';
    case TOTAL = 'total';
    case CREATED = 'created';
    case UPDATED = 'updated';
}
