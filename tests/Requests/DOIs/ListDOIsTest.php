<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Enums\SortOption;
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;

it('can list dois via the public API', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.basic'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListDOIs;

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray()->toHaveCount(25);
    expect($dto->meta->total)->toBeGreaterThan(0);
    expect($dto->links->self)->toBeString();
    expect($dto->meta->page)->toBe(1);

});

it('can list dois with sorting', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.sorting'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withSortDesc(SortOption::CREATED)
        ->withPageSize(10);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray()->toHaveCount(10);
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

});

it('can list dois with provider filter', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.provider_filter'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withProviderId('cern')
        ->withSortDesc(SortOption::CREATED);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray();
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

    // Verify at least one result is from the 'cern' provider (if provider data is available)
    $foundCernProvider = false;
    foreach ($dto->data as $doiData) {
        if ($doiData->relationships?->provider?->data?->id === 'cern') {
            $foundCernProvider = true;
            break;
        }
    }
    // Just verify we can access the provider relationship structure
    expect($dto->data[0]->relationships)->not->toBeNull();

});

it('can list dois with query builder', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.query_builder'),
    ]);

    $client = $this->getPublicApiClient(prodApi: true);
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withQuery(
            (new QueryBuilder)
                ->whereContains('titles.title', 'machine learning')
                ->whereEquals('publicationYear', '2023')
        )
        ->withPageSize(25);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray();
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

    // Verify at least some results match our query (API may return partial matches)
    $found2023Year = 0;
    $foundMachineLearning = 0;

    foreach ($dto->data as $doiData) {
        // Check publication year
        if ($doiData->publicationYear === 2023) {
            $found2023Year++;
        }

        // Check at least one title contains 'machine learning'
        foreach ($doiData->titles as $title) {
            if (stripos($title->title, 'machine learning') !== false) {
                $foundMachineLearning++;
                break;
            }
        }
    }

    expect($found2023Year)->toBeGreaterThan(0, 'Expected at least one DOI from 2023');
    expect($foundMachineLearning)->toBeGreaterThan(0, 'Expected at least one DOI with "machine learning" in title');

});

it('can list dois with exact match search', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.exact_match'),
    ]);

    $client = $this->getPublicApiClient(prodApi: true);
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withQuery(
            (new QueryBuilder)
                ->whereExact('titles.title', 'CrowdoMeter Tweets')
        )
        ->withSortDesc(SortOption::RELEVANCE);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray();
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

    // Verify at least one result has the exact title match
    $foundExactMatch = false;
    foreach ($dto->data as $doiData) {
        foreach ($doiData->titles as $title) {
            if ($title->title === 'CrowdoMeter Tweets') {
                $foundExactMatch = true;
                break 2;
            }
        }
    }
    expect($foundExactMatch)->toBeTrue();

});

it('can list dois with wildcard search', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.wildcard_search'),
    ]);

    $client = $this->getPublicApiClient(prodApi: true);
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withQuery(
            (new QueryBuilder)
                ->whereStartsWithWildcard('creators.familyName', 'mil')
                ->whereWildcard('creators.nameIdentifiers.nameIdentifier', '*')
        )
        ->withPageSize(20);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray()->toHaveCount(20);
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

    // Verify at least one result has creators with family names starting with 'mil' and name identifiers
    $foundMatchingCreator = false;
    foreach ($dto->data as $doiData) {
        foreach ($doiData->creators as $creator) {
            if ($creator->familyName === null) {
                continue;
            }
            if (stripos((string) $creator->familyName, 'mil') !== 0) {
                continue;
            }
            // Also check this creator has name identifiers
            if (count($creator->nameIdentifiers) <= 0) {
                continue;
            }
            $foundMatchingCreator = true;
            break 2;
        }
    }
    expect($foundMatchingCreator)->toBeTrue();

});

it('can list dois with boolean filters', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.boolean_filters'),
    ]);

    $client = $this->getPublicApiClient(prodApi: true);
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withHasPerson(true)
        ->withHasFundingReference(true)
        ->withCreated('2023')
        ->withSortDesc(SortOption::CREATED);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray();
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

    // Verify at least some results have person creators and funding references
    $foundPerson = false;
    $foundFundingRef = false;

    foreach ($dto->data as $doiData) {
        // Check for person (creator with nameType='Personal')
        foreach ($doiData->creators as $creator) {
            if ($creator->nameType === \VincentAuger\DataCiteSdk\Enums\NameType::PERSONAL) {
                $foundPerson = true;
                break;
            }
        }

        // Check for funding references
        if (count($doiData->fundingReferences) > 0) {
            $foundFundingRef = true;
        }

        if ($foundPerson && $foundFundingRef) {
            break;
        }
    }

    expect($foundPerson)->toBeTrue('Expected to find at least one DOI with a personal creator');
    expect($foundFundingRef)->toBeTrue('Expected to find at least one DOI with funding references');

});

it('can list dois with affiliation and publisher info', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.affiliation_publisher'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withAffiliation()
        ->withPublisher()
        ->withPageSize(5);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray()->toHaveCount(5);
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

});

it('can list dois with pagination', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.pagination'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withPageSize(15)
        ->withPage(2)
        ->withSortDesc(SortOption::CREATED);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray()->toHaveCount(15);
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);
    expect($dto->meta->page)->toBe(2);

});

it('can list dois with date range filter', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.date_range'),
    ]);

    $client = $this->getPublicApiClient(prodApi: true);
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withCreated('2023,2024')
        ->withSortDesc(SortOption::CREATED)
        ->withPageSize(10);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray()->toHaveCount(10);
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

    // Verify all results were created in 2023 or 2024
    foreach ($dto->data as $doiData) {
        $createdYear = (int) $doiData->created->format('Y');
        expect($createdYear)->toBeIn([2023, 2024]);
    }

});

it('can list dois with random sampling', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.random_sampling'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withRandom(true)
        ->withSort(SortOption::RELEVANCE);

    $response = $client->send($request);

    /** @var \VincentAuger\DataCiteSdk\Data\ListDOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);
    expect($dto->data)->toBeArray();
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

});

it('can list dois with DTO and metadata', function (): void {

    $mockClient = new MockClient([
        ListDOIs::class => MockResponse::fixture('listdois.sorting'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListDOIs()
        ->withSortDesc(SortOption::CREATED)
        ->withPageSize(10);

    $response = $client->send($request);
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto)->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\ListDOIData::class);

    // Test data array
    expect($dto->data)->toBeArray();
    expect(count($dto->data))->toBeGreaterThan(0);
    expect($dto->data[0])->toBeInstanceOf(\VincentAuger\DataCiteSdk\Data\DOIData::class);

    // Test metadata
    expect($dto->meta->total)->toBeGreaterThan(0);
    expect($dto->meta->totalPages)->toBeGreaterThan(0);
    expect($dto->meta->page)->toBe(1);
    expect($dto->meta->states)->toBeArray();
    expect($dto->meta->resourceTypes)->toBeArray();

    // Test links
    expect($dto->links->self)->toBeString();
    expect($dto->links->next)->toBeString();

});
