<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\DataCiteSdk\Data\CreateDOIInput;
use VincentAuger\DataCiteSdk\Data\DOIData;
use VincentAuger\DataCiteSdk\Traits\Requests\RequiresMemberAuth;

/**
 * Create a new DOI
 *
 * This endpoint requires member API authentication.
 */
final class CreateDOI extends Request implements HasBody
{
    use CreatesDtoFromResponse;
    use HasJsonBody;
    use RequiresMemberAuth;

    protected Method $method = Method::POST;

    public function __construct(private readonly CreateDOIInput $doiInput) {}

    public function resolveEndpoint(): string
    {
        return '/dois';
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
