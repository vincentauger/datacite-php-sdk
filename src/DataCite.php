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
 */
final class DataCite extends Connector
{
    public function __construct(
        public readonly string $baseUrl = 'https://api.datacite.org',
        public readonly ApiVersion $apiVersion = ApiVersion::PUBLIC,
        private readonly ?string $username = null,
        private readonly ?string $password = null,
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

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
            'User-Agent' => 'DataCite-PHP-SDK PHP/' . PHP_VERSION,
        ];
    }
}
