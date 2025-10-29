<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class GetHeartbeat extends Request
{
    protected Method $method = Method::GET;

    public function __construct() {}

    public function resolveEndpoint(): string
    {
        return '/heartbeat';
    }
}
