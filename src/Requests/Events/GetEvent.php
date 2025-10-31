<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\Events;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\DataCiteSdk\Data\EventData;

/**
 * Get a single event by ID.
 *
 * @see https://support.datacite.org/docs/eventdata-api-guide#get-an-event
 */
final class GetEvent extends Request
{
    use CreatesDtoFromResponse;

    protected Method $method = Method::GET;

    public function __construct(private string $id) {}

    public function resolveEndpoint(): string
    {
        return '/events/'.$this->id;
    }

    public function createDtoFromResponse(Response $response): EventData
    {
        /** @var array<string, mixed> $data */
        $data = $response->json('data');

        return EventData::fromArray($data);
    }
}
