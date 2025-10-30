<?php

declare(strict_types=1);

use VincentAuger\DataCiteSdk\Data\Identifiers\RelatedItem;
use VincentAuger\DataCiteSdk\Data\Identifiers\RelatedItemIdentifier;
use VincentAuger\DataCiteSdk\Data\Metadata\Title;
use VincentAuger\DataCiteSdk\Enums\RelationType;
use VincentAuger\DataCiteSdk\Enums\ResourceTypeGeneral;

test('RelatedItem with HasMetadata relation type includes metadata scheme properties', function (): void {
    $identifier = new RelatedItemIdentifier(
        relatedItemIdentifier: '1234-5678',
        relatedItemIdentifierType: 'DOI',
        relatedMetadataScheme: 'FGDC',
        schemeURI: 'https://example.com/scheme',
        schemeType: 'XSD'
    );

    $relatedItem = new RelatedItem(
        titles: [new Title(title: 'Test Title')],
        relationType: RelationType::HAS_METADATA,
        relatedItemType: ResourceTypeGeneral::DATASET,
        relatedItemIdentifier: $identifier
    );

    $array = $relatedItem->toArray();

    expect($array['relatedItemIdentifier'])->toBeArray();
    expect($array['relatedItemIdentifier']['relatedMetadataScheme'])->toBe('FGDC');
    expect($array['relatedItemIdentifier']['schemeURI'])->toBe('https://example.com/scheme');
    expect($array['relatedItemIdentifier']['schemeType'])->toBe('XSD');
});

test('RelatedItem with IsMetadataFor relation type includes metadata scheme properties', function (): void {
    $identifier = new RelatedItemIdentifier(
        relatedItemIdentifier: '1234-5678',
        relatedItemIdentifierType: 'DOI',
        relatedMetadataScheme: 'FGDC',
        schemeURI: 'https://example.com/scheme',
        schemeType: 'XSD'
    );

    $relatedItem = new RelatedItem(
        titles: [new Title(title: 'Test Title')],
        relationType: RelationType::IS_METADATA_FOR,
        relatedItemType: ResourceTypeGeneral::DATASET,
        relatedItemIdentifier: $identifier
    );

    $array = $relatedItem->toArray();

    expect($array['relatedItemIdentifier'])->toBeArray();
    expect($array['relatedItemIdentifier']['relatedMetadataScheme'])->toBe('FGDC');
    expect($array['relatedItemIdentifier']['schemeURI'])->toBe('https://example.com/scheme');
    expect($array['relatedItemIdentifier']['schemeType'])->toBe('XSD');
});

test('RelatedItem with Cites relation type excludes metadata scheme properties', function (): void {
    $identifier = new RelatedItemIdentifier(
        relatedItemIdentifier: '1234-5678',
        relatedItemIdentifierType: 'DOI',
        relatedMetadataScheme: 'FGDC',
        schemeURI: 'https://example.com/scheme',
        schemeType: 'XSD'
    );

    $relatedItem = new RelatedItem(
        titles: [new Title(title: 'Test Title')],
        relationType: RelationType::CITES,
        relatedItemType: ResourceTypeGeneral::DATASET,
        relatedItemIdentifier: $identifier
    );

    $array = $relatedItem->toArray();

    expect($array['relatedItemIdentifier'])->toBeArray();
    expect($array['relatedItemIdentifier'])->not->toHaveKey('relatedMetadataScheme');
    expect($array['relatedItemIdentifier'])->not->toHaveKey('schemeURI');
    expect($array['relatedItemIdentifier'])->not->toHaveKey('schemeType');
    expect($array['relatedItemIdentifier']['relatedItemIdentifier'])->toBe('1234-5678');
    expect($array['relatedItemIdentifier']['relatedItemIdentifierType'])->toBe('DOI');
});

test('RelatedItemIdentifier can be created and serialized without metadata scheme properties', function (): void {
    $identifier = new RelatedItemIdentifier(
        relatedItemIdentifier: '10.1234/test',
        relatedItemIdentifierType: 'DOI'
    );

    $array = $identifier->toArray();

    expect($array)->toBeArray();
    expect($array['relatedItemIdentifier'])->toBe('10.1234/test');
    expect($array['relatedItemIdentifierType'])->toBe('DOI');
    expect($array)->not->toHaveKey('relatedMetadataScheme');
    expect($array)->not->toHaveKey('schemeURI');
    expect($array)->not->toHaveKey('schemeType');
});

test('RelatedItemIdentifier can be created from array with metadata scheme properties', function (): void {
    $data = [
        'relatedItemIdentifier' => '10.1234/test',
        'relatedItemIdentifierType' => 'DOI',
        'relatedMetadataScheme' => 'FGDC',
        'schemeURI' => 'https://example.com/scheme',
        'schemeType' => 'XSD',
    ];

    $identifier = RelatedItemIdentifier::fromArray($data);

    expect($identifier->relatedItemIdentifier)->toBe('10.1234/test');
    expect($identifier->relatedItemIdentifierType)->toBe('DOI');
    expect($identifier->relatedMetadataScheme)->toBe('FGDC');
    expect($identifier->schemeURI)->toBe('https://example.com/scheme');
    expect($identifier->schemeType)->toBe('XSD');
});
