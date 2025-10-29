<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Data\DOIData;
use VincentAuger\DataCiteSdk\Enums\ResourceTypeGeneral;
use VincentAuger\DataCiteSdk\Requests\DOIs\GetDOI;

it('can get a doi via the public API', function (): void {

    $mockClient = new MockClient([
        GetDOI::class => MockResponse::fixture('getdoi'),
    ]);

    $client = $this->getPublicApiClient(prodApi: true);
    $client->withMockClient($mockClient);

    $request = new GetDOI('10.5438/0012');

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.5438/0012');

    /** @var VincentAuger\DataCiteSdk\Data\DOIData $doi */
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

    /** @var VincentAuger\DataCiteSdk\Data\DOIData $doi */
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

    /** @var VincentAuger\DataCiteSdk\Data\DOIData $doi */
    $doi = $response->dto();

    expect($doi)->toBeInstanceOf(DOIData::class);
    expect($doi->doi)->toBe('10.82785/1989de32-bc5d-c696-879c-54d422438e64');
    expect($doi->types->resourceTypeGeneral)->toBe(ResourceTypeGeneral::DATASET);
});

it('can get a doi with affiliation and publisher info via the public API', function (): void {

    $mockClient = new MockClient([
        GetDOI::class => MockResponse::fixture('public.getdoi.affiliation_publisher'),
    ]);

    $client = $this->getPublicApiClient(prodApi: true);
    $client->withMockClient($mockClient);

    $request = new GetDOI('10.60825/xd80-gb65')
        ->withAffiliation()
        ->withPublisher();

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.60825/xd80-gb65');
    expect($response->json('data.attributes.publisher.publisherIdentifier'))->toBe('https://ror.org/02qa1x782');

    /** @var VincentAuger\DataCiteSdk\Data\DOIData $doi */
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

    $request = new GetDOI('10.82433/b09z-4k37')->withPublisher()->withAffiliation();

    $response = $client->send($request);

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe('10.82433/b09z-4k37');

    /** @var VincentAuger\DataCiteSdk\Data\DOIData $doi */
    $doi = $response->dto();

    expect($doi)->toBeInstanceOf(DOIData::class);

    // Basic DOI properties
    expect($doi->id)->toBe('10.82433/b09z-4k37');
    expect($doi->type)->toBe('dois');
    expect($doi->doi)->toBe('10.82433/b09z-4k37');
    expect($doi->prefix)->toBe('10.82433');
    expect($doi->suffix)->toBe('b09z-4k37');
    expect($doi->publicationYear)->toBe(2023);

    // Identifiers
    expect($doi->identifiers)->toHaveCount(1);
    expect($doi->identifiers[0]->identifier)->toBe('12345');
    expect($doi->identifiers[0]->identifierType)->toBe('Local accession number');

    // Alternate identifiers
    expect($doi->alternateIdentifiers)->toHaveCount(1);
    expect($doi->alternateIdentifiers[0]->alternateIdentifier)->toBe('12345');
    expect($doi->alternateIdentifiers[0]->alternateIdentifierType)->toBe('Local accession number');

    // Creators
    expect($doi->creators)->toHaveCount(2);
    expect($doi->creators[0]->name)->toBe('ExampleFamilyName, ExampleGivenName');
    expect($doi->creators[0]->nameType)->toBe(\VincentAuger\DataCiteSdk\Enums\NameType::PERSONAL);
    expect($doi->creators[0]->givenName)->toBe('ExampleGivenName');
    expect($doi->creators[0]->familyName)->toBe('ExampleFamilyName');
    expect($doi->creators[0]->affiliation)->toHaveCount(1);
    expect($doi->creators[0]->affiliation[0]->name)->toBe('ExampleAffiliation');
    expect($doi->creators[0]->affiliation[0]->schemeUri)->toBe('https://ror.org');
    expect($doi->creators[0]->affiliation[0]->affiliationIdentifier)->toBe('https://ror.org/04wxnsj81');
    expect($doi->creators[0]->affiliation[0]->affiliationIdentifierScheme)->toBe('ROR');
    expect($doi->creators[0]->nameIdentifiers)->toHaveCount(1);
    expect($doi->creators[0]->nameIdentifiers[0]->schemeUri)->toBe('https://orcid.org');
    expect($doi->creators[0]->nameIdentifiers[0]->nameIdentifier)->toBe('https://orcid.org/0000-0001-5727-2427');
    expect($doi->creators[0]->nameIdentifiers[0]->nameIdentifierScheme)->toBe('ORCID');

    // Second creator (organizational)
    expect($doi->creators[1]->name)->toBe('ExampleOrganization');
    expect($doi->creators[1]->nameType)->toBe(\VincentAuger\DataCiteSdk\Enums\NameType::ORGANIZATIONAL);
    expect($doi->creators[1]->affiliation)->toBeEmpty();
    expect($doi->creators[1]->nameIdentifiers)->toHaveCount(1);
    expect($doi->creators[1]->nameIdentifiers[0]->schemeUri)->toBe('https://ror.org');
    expect($doi->creators[1]->nameIdentifiers[0]->nameIdentifier)->toBe('https://ror.org/04wxnsj81');
    expect($doi->creators[1]->nameIdentifiers[0]->nameIdentifierScheme)->toBe('ROR');

    // Titles
    expect($doi->titles)->toHaveCount(4);
    expect($doi->titles[0]->title)->toBe('Example Title');
    expect($doi->titles[0]->lang)->toBe('en');
    expect($doi->titles[1]->title)->toBe('Example Subtitle');
    expect($doi->titles[1]->titleType)->toBe(\VincentAuger\DataCiteSdk\Enums\TitleType::SUBTITLE);
    expect($doi->titles[2]->title)->toBe('Example TranslatedTitle');
    expect($doi->titles[2]->titleType)->toBe(\VincentAuger\DataCiteSdk\Enums\TitleType::TRANSLATED_TITLE);
    expect($doi->titles[2]->lang)->toBe('fr');
    expect($doi->titles[3]->title)->toBe('Example AlternativeTitle');
    expect($doi->titles[3]->titleType)->toBe(\VincentAuger\DataCiteSdk\Enums\TitleType::ALTERNATIVE_TITLE);

    // Publisher
    expect($doi->publisher)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Affiliations\PublisherData::class);
    expect($doi->publisher->name)->toBe('Example Publisher');
    expect($doi->publisher->lang)->toBe('en');
    expect($doi->publisher->schemeUri)->toBe('https://ror.org/');
    expect($doi->publisher->publisherIdentifier)->toBe('https://ror.org/04z8jg394');
    expect($doi->publisher->publisherIdentifierScheme)->toBe('ROR');

    // Container
    expect($doi->container)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Metadata\ContainerData::class);
    expect($doi->container->type)->toBe('DataRepository');
    expect($doi->container->title)->toBe('Example SeriesInformation');
    expect($doi->container->firstPage)->toBeNull();

    // Subjects
    expect($doi->subjects)->not->toBeEmpty();
    expect($doi->subjects[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Metadata\Subject::class);

    // Contributors
    expect($doi->contributors)->not->toBeEmpty();
    expect($doi->contributors[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Metadata\Contributor::class);

    // Dates
    expect($doi->dates)->not->toBeEmpty();
    expect($doi->dates[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Metadata\Date::class);

    // Language
    expect($doi->language)->toBeString();

    // Types
    expect($doi->types)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Metadata\TypeData::class);

    // Related identifiers
    expect($doi->relatedIdentifiers)->not->toBeEmpty();
    expect($doi->relatedIdentifiers[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Identifiers\RelatedIdentifier::class);

    // Related items
    expect($doi->relatedItems)->not->toBeEmpty();
    expect($doi->relatedItems[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Identifiers\RelatedItem::class);
    expect($doi->relatedItems[0]->contributors)->not->toBeEmpty();
    expect($doi->relatedItems[0]->contributors[0]->name)->toBe('ExampleFamilyName, ExampleGivenName');
    expect($doi->relatedItems[0]->creators)->not->toBeEmpty();
    expect($doi->relatedItems[0]->creators[0]->name)->toBe('ExampleFamilyName, ExampleGivenName');

    // Sizes and formats
    expect($doi->sizes)->toBeArray();
    expect($doi->formats)->toBeArray();

    // Version
    expect($doi->version)->toBeString();

    // Rights list
    expect($doi->rightsList)->not->toBeEmpty();
    expect($doi->rightsList[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Metadata\RightsList::class);

    // Descriptions
    expect($doi->descriptions)->not->toBeEmpty();
    expect($doi->descriptions[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Metadata\Description::class);

    // Geo locations
    expect($doi->geoLocations)->not->toBeEmpty();
    expect($doi->geoLocations[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\GeoLocation\GeoLocation::class);
    expect($doi->geoLocations[0]->geoLocationPolygon)->not->toBeEmpty();

    // Funding references
    expect($doi->fundingReferences)->not->toBeEmpty();
    expect($doi->fundingReferences[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Metadata\FundingReference::class);

    // XML and URLs
    expect($doi->xml)->toBeString();
    expect($doi->url)->toBeString();
    expect($doi->contentUrl)->toBeNull();

    // Metadata info
    expect($doi->metadataVersion)->toBeInt();
    expect($doi->schemaVersion)->toBeString();
    expect($doi->source)->toBeString();

    // Status
    expect($doi->isActive)->toBeBool();
    expect($doi->state)->toBeString();
    expect($doi->reason)->toBeNull();

    // Statistics
    expect($doi->viewCount)->toBeInt();
    expect($doi->viewsOverTime)->toBeArray();
    expect($doi->downloadCount)->toBeInt();
    expect($doi->downloadsOverTime)->toBeArray();
    expect($doi->referenceCount)->toBeInt();
    expect($doi->citationCount)->toBeInt();
    expect($doi->citationsOverTime)->toBeArray();
    expect($doi->partCount)->toBeInt();
    expect($doi->partOfCount)->toBeInt();
    expect($doi->versionCount)->toBeInt();
    expect($doi->versionOfCount)->toBeInt();

    // Dates
    expect($doi->created)->toBeInstanceOf(\DateTimeImmutable::class);
    expect($doi->registered)->toBeInstanceOf(\DateTimeImmutable::class);
    expect($doi->published)->toBeString();
    expect($doi->updated)->toBeInstanceOf(\DateTimeImmutable::class);

    // Relationships
    expect($doi->relationships)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Relationships\RelationshipData::class);
    expect($doi->relationships->client)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Relationships\RelationshipClient::class);
    expect($doi->relationships->provider)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Relationships\RelationshipProvider::class);
    expect($doi->relationships->media)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\Relationships\RelationshipMedia::class);
    expect($doi->relationships->citations)->toBeArray();

});
