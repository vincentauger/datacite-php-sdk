<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Data\EventData;
use VincentAuger\DataCiteSdk\Data\ListEventData;
use VincentAuger\DataCiteSdk\Enums\EventSortOption;
use VincentAuger\DataCiteSdk\Requests\Events\ListEvents;

it('can list events via the public API', function (): void {

    $mockClient = new MockClient([
        ListEvents::class => MockResponse::fixture('listevents.basic'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListEvents;

    $response = $client->send($request);

    /** @var ListEventData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200)
        ->and($dto)->toBeInstanceOf(ListEventData::class)
        ->and($dto->data)->toBeArray()
        ->and($dto->meta->total)->toBeInt()->toBeGreaterThan(0)
        ->and($dto->meta->totalPages)->toBeInt()->toBeGreaterThan(0)
        ->and($dto->meta->page)->toBe(1)
        ->and($dto->links->self)->toBeString();

    // Verify first event has proper structure
    if (count($dto->data) > 0) {
        expect($dto->data[0])->toBeInstanceOf(EventData::class)
            ->and($dto->data[0]->id)->toBeString()
            ->and($dto->data[0]->type)->toBe('events');
    }
});

it('can list events with DOI filter', function (): void {

    $mockClient = new MockClient([
        ListEvents::class => MockResponse::fixture('listevents.doi_filter'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListEvents()
        ->withDoi('10.5061/dryad.8515')
        ->withPageSize(10);

    $response = $client->send($request);

    /** @var ListEventData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200)
        ->and($dto)->toBeInstanceOf(ListEventData::class)
        ->and($dto->data)->toBeArray();

    // Verify events are related to the DOI
    if (count($dto->data) > 0) {
        expect($dto->data[0])->toBeInstanceOf(EventData::class);
    }
});

it('can list events with source filter', function (): void {

    $mockClient = new MockClient([
        ListEvents::class => MockResponse::fixture('listevents.source_filter'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListEvents()
        ->withSourceId('datacite-usage')
        ->withPageSize(10);

    $response = $client->send($request);

    /** @var ListEventData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200)
        ->and($dto)->toBeInstanceOf(ListEventData::class)
        ->and($dto->data)->toBeArray();
});

it('can list events with relation type filter', function (): void {

    $mockClient = new MockClient([
        ListEvents::class => MockResponse::fixture('listevents.relation_type_filter'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListEvents()
        ->withRelationTypeId(['is-cited-by', 'cites'])
        ->withPageSize(10);

    $response = $client->send($request);

    /** @var ListEventData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200)
        ->and($dto)->toBeInstanceOf(ListEventData::class)
        ->and($dto->data)->toBeArray();
});

it('can list events with sorting', function (): void {

    $mockClient = new MockClient([
        ListEvents::class => MockResponse::fixture('listevents.sorting'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListEvents()
        ->withSortDesc(EventSortOption::TOTAL)
        ->withPageSize(10);

    $response = $client->send($request);

    /** @var ListEventData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200)
        ->and($dto)->toBeInstanceOf(ListEventData::class)
        ->and($dto->data)->toBeArray();
});

it('can list events with prefix filter', function (): void {

    $mockClient = new MockClient([
        ListEvents::class => MockResponse::fixture('listevents.prefix_filter'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListEvents()
        ->withPrefix('10.5061')
        ->withPageSize(10);

    $response = $client->send($request);

    /** @var ListEventData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200)
        ->and($dto)->toBeInstanceOf(ListEventData::class)
        ->and($dto->data)->toBeArray();
});

it('can list events with year-month filter', function (): void {

    $mockClient = new MockClient([
        ListEvents::class => MockResponse::fixture('listevents.year_month_filter'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListEvents()
        ->withYearMonth('2024-01')
        ->withPageSize(10);

    $response = $client->send($request);

    /** @var ListEventData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200)
        ->and($dto)->toBeInstanceOf(ListEventData::class)
        ->and($dto->data)->toBeArray();
});

it('can list events with pagination', function (): void {

    $mockClient = new MockClient([
        ListEvents::class => MockResponse::fixture('listevents.pagination'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new ListEvents()
        ->withPage(2)
        ->withPageSize(5);

    $response = $client->send($request);

    /** @var ListEventData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200)
        ->and($dto)->toBeInstanceOf(ListEventData::class)
        ->and($dto->data)->toBeArray()
        ->and($dto->meta->page)->toBe(2);
});
