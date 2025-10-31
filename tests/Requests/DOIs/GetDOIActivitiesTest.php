<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Data\ActivityData;
use VincentAuger\DataCiteSdk\Data\DOIActivitiesData;
use VincentAuger\DataCiteSdk\Requests\DOIs\GetDOIActivities;

it('can get a dois activities via the public API', function (): void {

    $mockClient = new MockClient([
        GetDOIActivities::class => MockResponse::fixture('getdoi.activities'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new GetDOIActivities('10.82785/1989de32-bc5d-c696-879c-54d422438e64');

    $response = $client->send($request);

    expect($response->status())->toBe(200);

    $dto = $request->createDtoFromResponse($response);

    expect($dto)->toBeInstanceOf(DOIActivitiesData::class)
        ->and($dto->data)->toBeArray()
        ->and($dto->data[0])->toBeInstanceOf(ActivityData::class)
        ->and($dto->data[0]->id)->toBe('20c32f06-b133-42a9-a5b1-9068d5b5329c')
        ->and($dto->data[0]->type)->toBe('activities')
        ->and($dto->data[0]->attributes->action)->toBe('update')
        ->and($dto->data[0]->attributes->version)->toBe(351)
        ->and($dto->data[0]->attributes->changes)->toBeArray()
        ->and($dto->data[0]->attributes->changes)->toHaveKey('landing_page')
        ->and($dto->meta->total)->toBeInt()
        ->and($dto->meta->totalPages)->toBeInt()
        ->and($dto->meta->page)->toBeInt()
        ->and($dto->links->self)->toBeString();

});
