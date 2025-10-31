<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Data\EventData;
use VincentAuger\DataCiteSdk\Enums\EventMessageAction;
use VincentAuger\DataCiteSdk\Enums\EventRelationType;
use VincentAuger\DataCiteSdk\Enums\EventSource;
use VincentAuger\DataCiteSdk\Requests\Events\GetEvent;

it('can get an individual event', function (): void {

    $mockClient = new MockClient([
        GetEvent::class => MockResponse::fixture('getevent'),
    ]);

    $client = $this->getPublicApiClient();
    $client->withMockClient($mockClient);

    $request = new GetEvent('d04a4c7a-2f19-4002-b8e7-06a844b5716f');

    $response = $client->send($request);

    expect($response->status())->toBe(200);

    $event = $response->dto();

    expect($event)->toBeInstanceOf(EventData::class)
        ->and($event->id)->toBe('d04a4c7a-2f19-4002-b8e7-06a844b5716f')
        ->and($event->type)->toBe('events')
        ->and($event->attributes->subjId)->toBe('https://api.test.datacite.org/reports/a8025c2b-ae9f-48d8-8dc3-d1133fff1502')
        ->and($event->attributes->objId)->toBe('https://doi.org/10.6073/pasta/aec48ca27decb1fd2c2f454f1c5f88e4')
        ->and($event->attributes->sourceId)->toBe(EventSource::DATACITE_USAGE)
        ->and($event->attributes->relationTypeId)->toBe(EventRelationType::TOTAL_DATASET_REQUESTS_REGULAR)
        ->and($event->attributes->total)->toBe(349)
        ->and($event->attributes->messageAction)->toBe(EventMessageAction::CREATE)
        ->and($event->attributes->sourceToken)->toBe('43ba99ae-5cf0-11e8-9c2d-fa7ae01bbebc')
        ->and($event->attributes->license)->toBe('https://creativecommons.org/publicdomain/zero/1.0/')
        ->and($event->attributes->occurredAt)->toBe('2018-05-22T00:00:00.000Z')
        ->and($event->attributes->timestamp)->toBe('2018-09-05T18:20:15.842Z')
        ->and($event->relationships->subj->data->id)->toBe('https://api.test.datacite.org/reports/a8025c2b-ae9f-48d8-8dc3-d1133fff1502')
        ->and($event->relationships->subj->data->type)->toBe('objects')
        ->and($event->relationships->obj->data->id)->toBe('https://doi.org/10.6073/pasta/aec48ca27decb1fd2c2f454f1c5f88e4')
        ->and($event->relationships->obj->data->type)->toBe('objects');

});
