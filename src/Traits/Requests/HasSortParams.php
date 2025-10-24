<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Traits\Requests;

use VincentAuger\DataCiteSdk\Enums\SortDirection;
use VincentAuger\DataCiteSdk\Enums\SortOption;

trait HasSortParams
{
    public function withSort(SortOption $sort, ?SortDirection $direction = null): self
    {
        $sortValue = $sort->value;

        // Apply direction if specified
        if ($direction === SortDirection::DESC) {
            $sortValue = "-{$sortValue}";
        }

        $this->query()->add('sort', $sortValue);

        return $this;
    }

    public function withSortAsc(SortOption $sort): self
    {
        return $this->withSort($sort, SortDirection::ASC);
    }

    public function withSortDesc(SortOption $sort): self
    {
        return $this->withSort($sort, SortDirection::DESC);
    }
}
