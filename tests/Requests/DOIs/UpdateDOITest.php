<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Data\DOIData;
use VincentAuger\DataCiteSdk\Data\UpdateDOIInput;
use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\ApiVersion;
use VincentAuger\DataCiteSdk\Requests\DOIs\UpdateDOI;

it('throws exception when using public API for member-only endpoint', function (): void {
    $publicClient = new DataCite(
        apiVersion: ApiVersion::PUBLIC
    );

    $doiInput = new UpdateDOIInput(
        url: 'https://example.com'
    );

    $request = new UpdateDOI('10.82785/pct3-b846', $doiInput);

    expect(fn (): \Saloon\Http\Response => $publicClient->send($request))
        ->toThrow(
            \RuntimeException::class,
            'requires member API authentication'
        );
});

it('can update a doi via the member API endpoint', function (): void {

    $mockClient = new MockClient([
        UpdateDOI::class => MockResponse::fixture('member.updatedoi'),
    ]);

    $client = $this->getMemberApiClient();
    $client->withMockClient($mockClient);

    $doiInput = new UpdateDOIInput(url: 'https://www.test2.com');

    $request = new UpdateDOI('10.82785/pct3-b846', $doiInput);
    $response = $client->send($request);

    /** @var DOIData $dto */
    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($dto->url)->toBe('https://www.test2.com');

});
