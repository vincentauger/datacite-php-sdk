<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Traits\Requests;

trait HasAdditionalInformation
{
    public function withAffiliation(bool $flag = true): self
    {
        $this->query()->add('affiliation', $flag ? 'true' : 'false');

        return $this;
    }

    public function withPublisher(bool $flag = true): self
    {
        $this->query()->add('publisher', $flag ? 'true' : 'false');

        return $this;
    }
}
