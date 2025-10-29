<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Traits\Requests;

use Saloon\Http\PendingRequest;
use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\ApiVersion;

trait RequiresMemberAuth
{
    public function boot(PendingRequest $pendingRequest): void
    {
        $connector = $pendingRequest->getConnector();

        if (! $connector instanceof DataCite) {
            throw new \RuntimeException('This request must be sent through a DataCite connector');
        }

        if ($connector->apiVersion !== ApiVersion::MEMBER) {
            throw new \RuntimeException(
                sprintf(
                    'The %s endpoint requires member API authentication. '.
                    'Create your DataCite client with ApiVersion::MEMBER and provide credentials.',
                    static::class
                )
            );
        }
    }
}
