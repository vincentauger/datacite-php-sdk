<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\DataCiteSdk\Data\DOIActivitiesData;
use VincentAuger\DataCiteSdk\Traits\Requests\HasAdditionalInformation;

/**
 * The activities API exposes all changes made to a particular DOI.
 */
final class GetDOIActivities extends Request
{
    use CreatesDtoFromResponse;
    use HasAdditionalInformation;

    protected Method $method = Method::GET;

    public function __construct(private string $doi) {}

    public function resolveEndpoint(): string
    {
        return '/dois/'.$this->doi.'/activities';
    }

    public function createDtoFromResponse(Response $response): DOIActivitiesData
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return DOIActivitiesData::fromArray($data);
    }
}
