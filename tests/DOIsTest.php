<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Data\DOIData;
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

    $doi = $response->dto();

    expect($doi)->toBeInstanceOf(DOIData::class);
    expect($doi->doi)->toBe('10.5438/0012');
    expect($doi->prefix)->toBe('10.5438');
    expect($doi->suffix)->toBe('0012');
    expect($doi->publicationYear)->toBe(2016);
    expect($doi->publisher)->toBe('DataCite e.V.');
    expect($doi->creators)->toHaveCount(1);
    expect($doi->creators[0]->name)->toBe('DataCite Metadata Working Group');
    expect($doi->titles)->toHaveCount(1);
    expect($doi->titles[0]->title)->toContain('DataCite Metadata Schema Documentation');

    expect($doi->relationships)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Relationships\RelationshipData::class);
    expect($doi->relationships->client)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Relationships\RelationshipClient::class);
    expect($doi->relationships->client->id)->toBe('datacite.datacite');
    expect($doi->relationships->client->type)->toBe('clients');
    expect($doi->relationships->provider)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Relationships\RelationshipProvider::class);
    expect($doi->relationships->provider->id)->toBe('datacite');
    expect($doi->relationships->media)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Relationships\RelationshipMedia::class);
    expect($doi->relationships->media->id)->toBe('10.5438/0012');
    expect($doi->relationships->citations)->toBeArray();
    expect($doi->relationships->citations)->not->toBeEmpty();
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

    $doi = $response->dto();

    expect($doi)->toBeInstanceOf(DOIData::class);
    expect($doi->doi)->toBe('10.5438/0012');
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

    $doi = $response->dto();

    expect($doi)->toBeInstanceOf(DOIData::class);
    expect($doi->doi)->toBe('10.5438/0012');
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

    $doi = $response->dto();

    expect($doi)->toBeInstanceOf(DOIData::class);
    expect($doi->doi)->toBe('10.60825/xd80-gb65');
    expect($doi->publisher)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Affiliations\PublisherData::class);
    expect($doi->publisher->publisherIdentifier)->toBe('https://ror.org/02qa1x782');
    expect($doi->creators)->toHaveCount(7);
    expect($doi->creators[0]->affiliation)->toBeArray();
    expect($doi->creators[0]->affiliation[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Affiliations\Affiliation::class);
    expect($doi->creators[0]->affiliation[0]->affiliationIdentifier)->not->toBeNull();
});
