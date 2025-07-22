<?php

declare(strict_types=1);

use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\ApiVersion;

it('can create a public API client', function (): void {
    $client = new DataCite;

    expect($client->apiVersion)->toBe(ApiVersion::PUBLIC);
    expect($client->baseUrl)->toBe('https://api.datacite.org');
});

it('can create a member API client with credentials', function (): void {

    $client = new DataCite(
        apiVersion: ApiVersion::MEMBER,
        username: 'test-user',
        password: 'test-pass'
    );

    expect($client->apiVersion)->toBe(ApiVersion::MEMBER);
});

it('throws exception when member API lacks credentials', function (): void {
    expect(fn (): \VincentAuger\DataCiteSdk\DataCite => new DataCite(apiVersion: ApiVersion::MEMBER))
        ->toThrow(\InvalidArgumentException::class, 'Username and password are required for member API access');
});
