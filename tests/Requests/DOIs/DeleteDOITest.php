<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\ApiVersion;
use VincentAuger\DataCiteSdk\Requests\DOIs\DeleteDOI;

it('throws exception when using public API for member-only endpoint', function (): void {
    $publicClient = new DataCite(
        apiVersion: ApiVersion::PUBLIC
    );

    $request = new DeleteDOI('10.82785/pct3-b846');

    expect(fn (): \Saloon\Http\Response => $publicClient->send($request))
        ->toThrow(
            \RuntimeException::class,
            'requires member API authentication'
        );
});

it('cannot delete a findable doi via the member API endpoint', function (): void {

    $mockClient = new MockClient([
        DeleteDOI::class => MockResponse::fixture('member.deleteNonDraftDoi'),
    ]);

    $client = $this->getMemberApiClient();
    $client->withMockClient($mockClient);

    $request = new DeleteDOI('10.82785/pct3-b846');
    $response = $client->send($request);

    expect($response->status())->toBe(405);

});

it('can delete a draft doi via the member API endpoint', function (): void {

    $mockClient = new MockClient([
        DeleteDOI::class => MockResponse::fixture('member.deleteDraftDoi'),
    ]);

    $client = $this->getMemberApiClient();
    $client->withMockClient($mockClient);

    $request = new DeleteDOI('10.82785/pfjp-4h37');
    $response = $client->send($request);

    expect($response->status())->toBe(204);

});
