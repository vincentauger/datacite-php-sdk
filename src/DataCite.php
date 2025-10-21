<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\BasicAuthenticator;
use Saloon\Http\Connector;
use VincentAuger\DataCiteSdk\Enums\ApiVersion;

/**
 * DataCite API Connector
 *
 * Supports both public (no auth) and member (basic auth) API access.
 * Public API is used by default.
 *
 * $mailto can be provided to identify the client in requests.
 */
final class DataCite extends Connector
{
    public function __construct(
        public readonly string $baseUrl = 'https://api.datacite.org',
        public readonly ApiVersion $apiVersion = ApiVersion::PUBLIC,
        private readonly ?string $username = null,
        private readonly ?string $password = null,
        private readonly ?string $mailto = null,
    ) {
        if ($this->apiVersion === ApiVersion::MEMBER && ($this->username === null || $this->password === null)) {
            throw new \InvalidArgumentException('Username and password are required for member API access');
        }
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultAuth(): ?Authenticator
    {
        return match ($this->apiVersion) {
            ApiVersion::MEMBER => new BasicAuthenticator(
                $this->username ?? throw new \LogicException('Username is required for member API'),
                $this->password ?? throw new \LogicException('Password is required for member API')
            ),
            ApiVersion::PUBLIC => null,
        };
    }

    /**
     * When making frequent requests to DataCite APIs using a script or integration,
     * include a User-Agent header with 1) an identification of your script or
     * integration and 2) contact information in a mailto:
     */
    protected function defaultHeaders(): array
    {

        $userAgent = 'VincentAuger/DataCite-PHP-SDK PHP/'.PHP_VERSION;
        if ($this->mailto !== null) {
            $userAgent .= ' (mailto:'.$this->mailto.')';
        }

        return [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
            'User-Agent' => $userAgent,
        ];
    }
}
