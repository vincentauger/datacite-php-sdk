<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Traits\Requests;

trait HasAdditionalInformation
{
    /**
     * Show additional affiliation information on the DOI
     */
    public function withAffiliation(bool $flag = true): self
    {
        $this->query()->add('affiliation', $flag ? 'true' : 'false');

        return $this;
    }

    /**
     * Show additional publisher information on the DOI
     */
    public function withPublisher(bool $flag = true): self
    {
        $this->query()->add('publisher', $flag ? 'true' : 'false');

        return $this;
    }
}
