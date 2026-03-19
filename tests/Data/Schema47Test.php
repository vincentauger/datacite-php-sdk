<?php

declare(strict_types=1);

use VincentAuger\DataCiteSdk\Data\Identifiers\RelatedIdentifier;
use VincentAuger\DataCiteSdk\Data\Identifiers\RelatedItem;
use VincentAuger\DataCiteSdk\Data\Metadata\Title;
use VincentAuger\DataCiteSdk\Enums\RelatedIdentifierType;
use VincentAuger\DataCiteSdk\Enums\RelationType;
use VincentAuger\DataCiteSdk\Enums\ResourceTypeGeneral;

// --- New enum values ---

test('ResourceTypeGeneral supports Poster', function (): void {
    $value = ResourceTypeGeneral::from('Poster');
    expect($value)->toBe(ResourceTypeGeneral::POSTER);
    expect($value->value)->toBe('Poster');
});

test('ResourceTypeGeneral supports Presentation', function (): void {
    $value = ResourceTypeGeneral::from('Presentation');
    expect($value)->toBe(ResourceTypeGeneral::PRESENTATION);
    expect($value->value)->toBe('Presentation');
});

test('RelatedIdentifierType supports RAiD', function (): void {
    $value = RelatedIdentifierType::from('RAiD');
    expect($value)->toBe(RelatedIdentifierType::RAID);
    expect($value->value)->toBe('RAiD');
});

test('RelatedIdentifierType supports SWHID', function (): void {
    $value = RelatedIdentifierType::from('SWHID');
    expect($value)->toBe(RelatedIdentifierType::SWHID);
    expect($value->value)->toBe('SWHID');
});

test('RelationType supports Other', function (): void {
    $value = RelationType::from('Other');
    expect($value)->toBe(RelationType::OTHER);
    expect($value->value)->toBe('Other');
});

// --- relationTypeInformation on RelatedIdentifier ---

test('RelatedIdentifier serializes relationTypeInformation', function (): void {
    $identifier = new RelatedIdentifier(
        schemeUri: null,
        schemeType: null,
        relationType: RelationType::CITES,
        relatedIdentifier: '10.1234/test',
        resourceTypeGeneral: null,
        relatedIdentifierType: RelatedIdentifierType::DOI,
        relatedMetadataScheme: null,
        relationTypeInformation: 'Custom relation info',
    );

    $array = $identifier->toArray();

    expect($array['relationTypeInformation'])->toBe('Custom relation info');
});

test('RelatedIdentifier omits relationTypeInformation when null', function (): void {
    $identifier = new RelatedIdentifier(
        schemeUri: null,
        schemeType: null,
        relationType: RelationType::CITES,
        relatedIdentifier: '10.1234/test',
        resourceTypeGeneral: null,
        relatedIdentifierType: RelatedIdentifierType::DOI,
        relatedMetadataScheme: null,
    );

    $array = $identifier->toArray();

    expect($array)->not->toHaveKey('relationTypeInformation');
});

test('RelatedIdentifier deserializes relationTypeInformation from array', function (): void {
    $data = [
        'relationType' => 'Cites',
        'relatedIdentifier' => '10.1234/test',
        'relatedIdentifierType' => 'DOI',
        'relationTypeInformation' => 'Custom relation info',
    ];

    $identifier = RelatedIdentifier::fromArray($data);

    expect($identifier->relationTypeInformation)->toBe('Custom relation info');
});

test('RelatedIdentifier fromArray sets relationTypeInformation to null when absent', function (): void {
    $data = [
        'relationType' => 'Cites',
        'relatedIdentifier' => '10.1234/test',
        'relatedIdentifierType' => 'DOI',
    ];

    $identifier = RelatedIdentifier::fromArray($data);

    expect($identifier->relationTypeInformation)->toBeNull();
});

// --- relationTypeInformation on RelatedItem ---

test('RelatedItem serializes relationTypeInformation', function (): void {
    $relatedItem = new RelatedItem(
        titles: [new Title(title: 'Test Title')],
        relationType: RelationType::CITES,
        relatedItemType: ResourceTypeGeneral::DATASET,
        relationTypeInformation: 'Custom relation info',
    );

    $array = $relatedItem->toArray();

    expect($array['relationTypeInformation'])->toBe('Custom relation info');
});

test('RelatedItem omits relationTypeInformation when null', function (): void {
    $relatedItem = new RelatedItem(
        titles: [new Title(title: 'Test Title')],
        relationType: RelationType::CITES,
        relatedItemType: ResourceTypeGeneral::DATASET,
    );

    $array = $relatedItem->toArray();

    expect($array)->not->toHaveKey('relationTypeInformation');
});

test('RelatedItem deserializes relationTypeInformation from array', function (): void {
    $data = [
        'titles' => [['title' => 'Test Title']],
        'relationType' => 'Cites',
        'relatedItemType' => 'Dataset',
        'relationTypeInformation' => 'Custom relation info',
    ];

    $relatedItem = RelatedItem::fromArray($data);

    expect($relatedItem->relationTypeInformation)->toBe('Custom relation info');
});

test('RelatedItem fromArray sets relationTypeInformation to null when absent', function (): void {
    $data = [
        'titles' => [['title' => 'Test Title']],
        'relationType' => 'Cites',
        'relatedItemType' => 'Dataset',
    ];

    $relatedItem = RelatedItem::fromArray($data);

    expect($relatedItem->relationTypeInformation)->toBeNull();
});
