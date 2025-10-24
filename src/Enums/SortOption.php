<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

enum SortOption: string
{
    case NAME = 'name';
    case CREATED = 'created';
    case UPDATED = 'updated';
    case PUBLISHED = 'published';
    case VIEW_COUNT = 'view-count';
    case DOWNLOAD_COUNT = 'download-count';
    case CITATION_COUNT = 'citation-count';
    case TITLE = 'title';
    case RELEVANCE = 'relevance';
}
