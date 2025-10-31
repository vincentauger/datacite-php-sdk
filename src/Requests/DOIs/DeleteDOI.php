<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use VincentAuger\DataCiteSdk\Traits\Requests\RequiresMemberAuth;

/**
   Update an existing DOI
 *
 * This endpoint requires member API authentication.
 */
final class DeleteDOI extends Request
{
    use RequiresMemberAuth;

    protected Method $method = Method::DELETE;

    public function __construct(private readonly string $doi) {}

    public function resolveEndpoint(): string
    {
        return '/dois/'.$this->doi;
    }
}
