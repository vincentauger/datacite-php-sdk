<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class GetDOI extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private string $doi) {}

    public function resolveEndpoint(): string
    {
        return '/dois/'.$this->doi;
    }

    /**
     * Set affiliation=true to see additional affiliation
     * information such as the affiliation identifier.
     */
    public function addAffiliation($flag = true): self
    {
        $this->query()->add('affiliation', $flag ? 'true' : 'false');

        return $this;
    }

    /**
     * Set publisher=true to see additional publisher
     * information such as the publisher identifier.
     */
    public function addPublisher($flag = true): self
    {
        $this->query()->add('publisher', $flag ? 'true' : 'false');

        return $this;
    }
}
