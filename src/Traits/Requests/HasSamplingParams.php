<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Traits\Requests;

use VincentAuger\DataCiteSdk\Enums\SampleGroup;

trait HasSamplingParams
{
    public function withRandom(bool $flag = true): self
    {
        $this->query()->add('random', $flag ? 'true' : 'false');

        return $this;
    }

    public function withSampleGroup(SampleGroup $sampleGroup): self
    {
        $this->query()->add('sample-group', $sampleGroup->value);

        return $this;
    }
}
