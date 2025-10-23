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

    $client = $this->getPublicApiClient('vincent.auger@gmai.com', true);
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

    $request = new GetDOI('10.82785/1989de32-bc5d-c696-879c-54d422438e64');

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.82785/1989de32-bc5d-c696-879c-54d422438e64');

    $doi = $response->dto();

    expect($doi)->toBeInstanceOf(DOIData::class);
    expect($doi->doi)->toBe('10.82785/1989de32-bc5d-c696-879c-54d422438e64');
});

it('can get a doi with affiliation and publisher info via the public API', function (): void {

    $mockClient = new MockClient([
        GetDOI::class => MockResponse::fixture('public.getdoi.affiliation_publisher'),
    ]);

    $client = $this->getPublicApiClient(prodApi: true);
    $client->withMockClient($mockClient);

    $request = new GetDOI('10.60825/xd80-gb65')
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

it('can parse a doi with all fields', function (): void {

    $mockClient = new MockClient([
        GetDOI::class => MockResponse::fixture('getdoi.all_fields'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new GetDOI('10.82433/b09z-4k37')->addPublisher()->addAffiliation();

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.82433/b09z-4k37');

    $doi = $response->dto();

    expect($doi)->toBeInstanceOf(DOIData::class);
    expect($doi->doi)->toBe('10.82433/b09z-4k37');
    expect($doi->prefix)->toBe('10.82433');
    expect($doi->suffix)->toBe('b09z-4k37');
    expect($doi->publicationYear)->toBe(2023);

    expect($doi->identifiers)->toHaveCount(1);
    expect($doi->identifiers[0]->identifier)->toBe('12345');
    expect($doi->identifiers[0]->identifierType)->toBe('Local accession number');

    expect($doi->alternateIdentifiers)->toHaveCount(1);
    expect($doi->alternateIdentifiers[0]->alternateIdentifier)->toBe('12345');

    expect($doi->creators)->toHaveCount(2);
    expect($doi->creators[0]->name)->toBe('ExampleFamilyName, ExampleGivenName');
    expect($doi->creators[0]->nameType)->toBe('Personal');
    expect($doi->creators[0]->givenName)->toBe('ExampleGivenName');
    expect($doi->creators[0]->familyName)->toBe('ExampleFamilyName');
    expect($doi->creators[0]->affiliation)->toHaveCount(1);
    expect($doi->creators[0]->affiliation[0]->name)->toBe('ExampleAffiliation');
    expect($doi->creators[0]->nameIdentifiers)->toHaveCount(1);

    expect($doi->titles)->toHaveCount(4);
    expect($doi->titles[0]->title)->toBe('Example Title');

    expect($doi->publisher)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Affiliations\PublisherData::class);
    expect($doi->publisher->name)->toBe('Example Publisher');
    expect($doi->publisher->publisherIdentifier)->toBe('https://ror.org/04z8jg394');

    expect($doi->container)->not->toBeNull();
    expect($doi->container->type)->toBe('DataRepository');
    expect($doi->container->title)->toBe('Example SeriesInformation');

    expect($doi->subjects)->not->toBeEmpty();
    expect($doi->contributors)->not->toBeEmpty();
    expect($doi->dates)->not->toBeEmpty();
    expect($doi->relatedIdentifiers)->not->toBeEmpty();
    expect($doi->relatedItems)->not->toBeEmpty();
    expect($doi->relatedItems[0]->contributors)->not->toBeEmpty();
    expect($doi->relatedItems[0]->contributors[0]->name)->toBe('ExampleFamilyName, ExampleGivenName');
    expect($doi->relatedItems[0]->creators)->not->toBeEmpty();
    expect($doi->relatedItems[0]->creators[0]->name)->toBe('ExampleFamilyName, ExampleGivenName');
    expect($doi->descriptions)->not->toBeEmpty();
    expect($doi->geoLocations)->not->toBeEmpty();
    expect($doi->geoLocations[0]->geoLocationPolygon)->not->toBeEmpty();
    expect($doi->fundingReferences)->not->toBeEmpty();
    expect($doi->rightsList)->not->toBeEmpty();

});
