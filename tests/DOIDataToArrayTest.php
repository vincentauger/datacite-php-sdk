<?php

declare(strict_types=1);

use VincentAuger\DataCiteSdk\Data\Affiliations\Affiliation;
use VincentAuger\DataCiteSdk\Data\DOIData;
use VincentAuger\DataCiteSdk\Data\Identifiers\NameIdentifier;
use VincentAuger\DataCiteSdk\Data\Metadata\Creator;
use VincentAuger\DataCiteSdk\Data\Metadata\Title;

test('it can serialize a simple DOI to array', function (): void {
    $fixtureJson = file_get_contents(__DIR__.'/Fixtures/Saloon/getdoi.json');
    $fixtureData = json_decode($fixtureJson, true);
    $responseData = json_decode((string) $fixtureData['data'], true);

    $doiData = DOIData::fromArray($responseData['data']);

    $serialized = $doiData->toArray();

    expect($serialized)->toBeArray()
        ->and($serialized)->toHaveKey('data')
        ->and($serialized['data'])->toHaveKey('type')
        ->and($serialized['data']['type'])->toBe('dois')
        ->and($serialized['data'])->toHaveKey('attributes')
        ->and($serialized['data']['attributes'])->toHaveKey('doi')
        ->and($serialized['data']['attributes'])->toHaveKey('creators')
        ->and($serialized['data']['attributes'])->toHaveKey('titles')
        ->and($serialized['data']['attributes'])->toHaveKey('publisher')
        ->and($serialized['data']['attributes'])->toHaveKey('publicationYear');
});

test('Creator can be serialized to array', function (): void {
    $affiliation = new Affiliation(
        name: 'Example University',
        schemeUri: 'https://ror.org',
        affiliationIdentifier: 'https://ror.org/03yrm5c26',
        affiliationIdentifierScheme: 'ROR'
    );

    $nameIdentifier = new NameIdentifier(
        schemeUri: 'https://orcid.org',
        nameIdentifier: 'https://orcid.org/0000-0002-1825-0097',
        nameIdentifierScheme: 'ORCID'
    );

    $creator = new Creator(
        name: 'John Doe',
        nameType: 'Personal',
        givenName: 'John',
        familyName: 'Doe',
        affiliation: [$affiliation],
        nameIdentifiers: [$nameIdentifier],
        lang: null
    );

    $array = $creator->toArray();

    expect($array)->toBe([
        'name' => 'John Doe',
        'nameType' => 'Personal',
        'givenName' => 'John',
        'familyName' => 'Doe',
        'affiliation' => [
            [
                'name' => 'Example University',
                'schemeUri' => 'https://ror.org',
                'affiliationIdentifier' => 'https://ror.org/03yrm5c26',
                'affiliationIdentifierScheme' => 'ROR',
            ],
        ],
        'nameIdentifiers' => [
            [
                'nameIdentifier' => 'https://orcid.org/0000-0002-1825-0097',
                'nameIdentifierScheme' => 'ORCID',
                'schemeUri' => 'https://orcid.org',
            ],
        ],
    ]);
});

test('Title can be serialized to array', function (): void {
    $title = new Title(
        lang: 'en',
        title: 'Test Title',
        titleType: 'MainTitle'
    );

    $array = $title->toArray();

    expect($array)->toBe([
        'title' => 'Test Title',
        'lang' => 'en',
        'titleType' => 'MainTitle',
    ]);
});

test('DOIData toArray omits empty arrays', function (): void {
    $fixtureJson = file_get_contents(__DIR__.'/Fixtures/Saloon/getdoi.json');
    $fixtureData = json_decode($fixtureJson, true);
    $responseData = json_decode((string) $fixtureData['data'], true);

    $doiData = DOIData::fromArray($responseData['data']);

    $serialized = $doiData->toArray();

    if (count($doiData->subjects) === 0) {
        expect($serialized['data']['attributes'])->not->toHaveKey('subjects');
    }
});
