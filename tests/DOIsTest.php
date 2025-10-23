<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Requests\DOIs\GetDOI;

it('can get a doi via the public API', function (): void {

    $mockClient = new MockClient([
        GetDOI::class => MockResponse::fixture('getdoi'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new GetDOI('10.5438/0012');

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.5438/0012');
});

it('can get a doi via the public API with email', function (): void {

    $mockClient = new MockClient([
        GetDOI::class => MockResponse::fixture('getdoi.public_email'),
    ]);

    $client = $this->getPublicApiClient('vincent.auger@gmai.com');
    $client->withMockClient($mockClient);

    $request = new GetDOI('10.5438/0012');

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.5438/0012');
});

it('cant get a doi via the member API', function (): void {

    $mockClient = new MockClient([
        GetDOI::class => MockResponse::fixture('member.getdoi'),
    ]);

    $client = $this->getMemberApiClient();
    $client->withMockClient($mockClient);

    $request = new GetDOI('10.5438/0012');

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.5438/0012');
});

it('can get a doi with affiliation and publisher info via the public API', function (): void {

    $mockClient = new MockClient([
        GetDOI::class => MockResponse::fixture('public.getdoi.affiliation_publisher'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = (new GetDOI('10.60825/xd80-gb65'))
        ->addAffiliation()
        ->addPublisher();

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.60825/xd80-gb65');
    expect($response->json('data.attributes.publisher.publisherIdentifier'))->toBe('https://ror.org/02qa1x782');
});
