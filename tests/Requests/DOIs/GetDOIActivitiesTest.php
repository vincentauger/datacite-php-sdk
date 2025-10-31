<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
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

});
