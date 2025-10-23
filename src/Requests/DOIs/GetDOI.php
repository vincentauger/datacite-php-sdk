<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\DataCiteSdk\Data\DOIData;

final class GetDOI extends Request
{
    use CreatesDtoFromResponse;

    protected Method $method = Method::GET;

    public function __construct(private string $doi) {}

    public function resolveEndpoint(): string
    {
        return '/dois/'.$this->doi;
    }

    public function createDtoFromResponse(Response $response): DOIData
    {
        return DOIData::fromArray($response->json('data'));
    }

    /**
     * Set affiliation=true to see additional affiliation
     * information such as the affiliation identifier.
     */
    public function addAffiliation(bool $flag = true): self
    {
        $this->query()->add('affiliation', $flag ? 'true' : 'false');

        return $this;
    }

    /**
     * Set publisher=true to see additional publisher
     * information such as the publisher identifier.
     */
    public function addPublisher(bool $flag = true): self
    {
        $this->query()->add('publisher', $flag ? 'true' : 'false');

        return $this;
    }
}
