<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\DataCiteSdk\Data\DOIData;
use VincentAuger\DataCiteSdk\Data\UpdateDOIInput;
use VincentAuger\DataCiteSdk\Traits\Requests\RequiresMemberAuth;

/**
   Update an existing DOI
 *
 * This endpoint requires member API authentication.
 */
final class UpdateDOI extends Request implements HasBody
{
    use CreatesDtoFromResponse;
    use HasJsonBody;
    use RequiresMemberAuth;

    protected Method $method = Method::PUT;

    public function __construct(private readonly string $doi, private readonly UpdateDOIInput $doiInput) {}

    public function resolveEndpoint(): string
    {
        return '/dois/'.$this->doi;
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return [
            'data' => [
                'type' => 'dois',
                'attributes' => $this->doiInput->toArray(),
            ],
        ];
    }

    public function createDtoFromResponse(Response $response): DOIData
    {
        /** @var array<string, mixed> $data */
        $data = $response->json('data');

        return DOIData::fromArray($data);
    }
}
