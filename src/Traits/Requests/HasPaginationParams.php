<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Traits\Requests;

use InvalidArgumentException;

trait HasPaginationParams
{
    public function withPage(int $page): self
    {
        $this->query()->add('page[number]', $page);

        return $this;
    }

    public function withPageSize(int $pageSize): self
    {
        if ($pageSize < 1 || $pageSize > 1000) {
            throw new InvalidArgumentException('Page size must be between 1 and 1000');
        }

        $this->query()->add('page[size]', $pageSize);

        return $this;
    }

    public function withCursor(string $cursor): self
    {
        $this->query()->add('page[cursor]', $cursor);

        return $this;
    }
}
