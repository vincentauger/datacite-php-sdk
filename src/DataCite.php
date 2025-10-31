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

    // =========================================================================
    // Convenience Methods for Quick Operations
    // =========================================================================

    /**
     * Check if the DataCite API is alive
     */
    public function heartbeat(): bool
    {
        $response = $this->send(new Requests\GetHeartbeat);

        return $response->status() === 200;
    }

    /**
     * Get a DOI by ID
     *
     * @param  string  $doi  The DOI identifier (e.g., '10.5438/0012')
     */
    public function getDOI(string $doi): \Saloon\Http\Response
    {
        return $this->send(new Requests\DOIs\GetDOI($doi));
    }

    /**
     * Get activities/changes for a DOI
     *
     * @param  string  $doi  The DOI identifier
     */
    public function getDOIActivities(string $doi): \Saloon\Http\Response
    {
        return $this->send(new Requests\DOIs\GetDOIActivities($doi));
    }

    /**
     * Create a new DOI (requires member authentication)
     *
     * @param  Data\CreateDOIInput  $input  The DOI metadata
     */
    public function createDOI(Data\CreateDOIInput $input): \Saloon\Http\Response
    {
        return $this->send(new Requests\DOIs\CreateDOI($input));
    }

    /**
     * Update an existing DOI (requires member authentication)
     *
     * @param  string  $doi  The DOI identifier
     * @param  Data\UpdateDOIInput  $input  The updated DOI metadata
     */
    public function updateDOI(string $doi, Data\UpdateDOIInput $input): \Saloon\Http\Response
    {
        return $this->send(new Requests\DOIs\UpdateDOI($doi, $input));
    }

    /**
     * Delete a DOI (requires member authentication)
     *
     * Note: Only DOIs in 'draft' state can be deleted.
     *
     * @param  string  $doi  The DOI identifier
     */
    public function deleteDOI(string $doi): \Saloon\Http\Response
    {
        return $this->send(new Requests\DOIs\DeleteDOI($doi));
    }

    /**
     * Get an event by ID
     *
     * @param  string  $eventId  The event identifier
     */
    public function getEvent(string $eventId): \Saloon\Http\Response
    {
        return $this->send(new Requests\Events\GetEvent($eventId));
    }
}
