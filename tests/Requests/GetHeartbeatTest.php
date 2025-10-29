<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Requests\GetHeartbeat;

it('can get a heartbeat', function (): void {

    $mockClient = new MockClient([
        GetHeartbeat::class => MockResponse::fixture('getheartbeat'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new GetHeartbeat;

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->getPsrResponse()->getReasonPhrase())->toBe('OK');

});

it('can get a heartbeat via connector', function (): void {

    $mockClient = new MockClient([
        GetHeartbeat::class => MockResponse::fixture('getheartbeat'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);
    $alive = $client->heartbeat();

    expect($alive)->toBe(true);

});
