<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\DataCiteSdk\Data\CreateDOIInput;
use VincentAuger\DataCiteSdk\Data\Identifiers\NameIdentifier;
use VincentAuger\DataCiteSdk\Data\Metadata\Creator;
use VincentAuger\DataCiteSdk\Data\Metadata\Title;
use VincentAuger\DataCiteSdk\Data\Metadata\TypeData;
use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\ApiVersion;
use VincentAuger\DataCiteSdk\Enums\NameType;
use VincentAuger\DataCiteSdk\Enums\ResourceTypeGeneral;
use VincentAuger\DataCiteSdk\Requests\DOIs\CreateDOI;

it('throws exception when using public API for member-only endpoint', function (): void {
    $publicClient = new DataCite(
        apiVersion: ApiVersion::PUBLIC
    );

    $creator = new Creator(name: 'Test Creator');
    $title = new Title(title: 'Test Title');

    $doiInput = new CreateDOIInput(
        prefix: '10.5438',
        creators: [$creator],
        titles: [$title],
        publicationYear: 2025,
        publisher: 'Test Publisher',
        types: new TypeData(resourceTypeGeneral: ResourceTypeGeneral::TEXT),
        url: 'https://example.com'
    );

    $request = new CreateDOI($doiInput);

    expect(fn (): \Saloon\Http\Response => $publicClient->send($request))
        ->toThrow(
            \RuntimeException::class,
            'requires member API authentication'
        );
});

it('can create a doi via the member API endpoint', function (): void {

    $mockClient = new MockClient([
        CreateDOI::class => MockResponse::fixture('member.createdoi'),
    ]);

    $client = $this->getMemberApiClient();
    $client->withMockClient($mockClient);

    $creator = new Creator(
        name: 'Vincent Auger',
        nameType: NameType::PERSONAL,
        givenName: 'Vincent',
        familyName: 'Auger',
        nameIdentifiers: [new NameIdentifier(
            schemeUri: 'https://orcid.org/',
            nameIdentifier: 'https://orcid.org/0000-0002-0595-6576',
            nameIdentifierScheme: 'ORCID'
        )],
    );

    $title = new Title(
        title: 'An example title',
        lang: 'en'
    );

    $doiInput = new CreateDOIInput(
        prefix: '10.82785',
        creators: [$creator],
        titles: [$title],
        publicationYear: 2025,
        publisher: 'test publisher',
        types: new TypeData(
            resourceTypeGeneral: ResourceTypeGeneral::TEXT,
        ),
        url: 'https://example.com',
    );

    $request = new CreateDOI($doiInput);
    $response = $client->send($request);

    expect($response->status())->toBe(201);

});
