<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

use DateTimeImmutable;
use VincentAuger\DataCiteSdk\Data\Affiliations\PublisherData;
use VincentAuger\DataCiteSdk\Data\GeoLocation\GeoLocation;
use VincentAuger\DataCiteSdk\Data\Identifiers\AlternateIdentifier;
use VincentAuger\DataCiteSdk\Data\Identifiers\Identifier;
use VincentAuger\DataCiteSdk\Data\Identifiers\RelatedIdentifier;
use VincentAuger\DataCiteSdk\Data\Identifiers\RelatedItem;
use VincentAuger\DataCiteSdk\Data\Metadata\ContainerData;
use VincentAuger\DataCiteSdk\Data\Metadata\Contributor;
use VincentAuger\DataCiteSdk\Data\Metadata\Creator;
use VincentAuger\DataCiteSdk\Data\Metadata\Date;
use VincentAuger\DataCiteSdk\Data\Metadata\Description;
use VincentAuger\DataCiteSdk\Data\Metadata\FundingReference;
use VincentAuger\DataCiteSdk\Data\Metadata\ResourceType;
use VincentAuger\DataCiteSdk\Data\Metadata\RightsList;
use VincentAuger\DataCiteSdk\Data\Metadata\Subject;
use VincentAuger\DataCiteSdk\Data\Metadata\Title;
use VincentAuger\DataCiteSdk\Data\Relationships\RelationshipData;

final readonly class DOIData
{
    /**
     * @param  non-empty-array<Creator>  $creators  Mandatory: At least one creator required per DataCite schema
     * @param  non-empty-array<Title>  $titles  Mandatory: At least one title required per DataCite schema
     * @param  Identifier[]  $identifiers
     * @param  AlternateIdentifier[]  $alternateIdentifiers
     * @param  Subject[]  $subjects
     * @param  Contributor[]  $contributors
     * @param  Date[]  $dates
     * @param  RelatedIdentifier[]  $relatedIdentifiers
     * @param  RelatedItem[]  $relatedItems
     * @param  string[]  $sizes
     * @param  string[]  $formats
     * @param  RightsList[]  $rightsList
     * @param  Description[]  $descriptions
     * @param  GeoLocation[]  $geoLocations
     * @param  FundingReference[]  $fundingReferences
     * @param  array<string, int>  $viewsOverTime
     * @param  array<string, int>  $downloadsOverTime
     * @param  array<string, int>  $citationsOverTime
     */
    public function __construct(
        public string $id,
        public string $type,
        public string $doi, // Mandatory: DataCite Property 1 (Identifier)
        public ?string $prefix,
        public ?string $suffix,
        public array $identifiers,
        public array $alternateIdentifiers,
        public array $creators, // Mandatory: DataCite Property 2 (Creator) - must be non-empty
        public array $titles, // Mandatory: DataCite Property 3 (Title) - must be non-empty
        public PublisherData|string $publisher, // Mandatory: DataCite Property 4 (Publisher)
        public ContainerData $container,
        public int $publicationYear, // Mandatory: DataCite Property 5 (PublicationYear)
        public array $subjects,
        public array $contributors,
        public array $dates,
        public ?string $language,
        public ResourceType $types, // Mandatory: DataCite Property 10 (ResourceType)
        public array $relatedIdentifiers,
        public array $relatedItems,
        public array $sizes,
        public array $formats,
        public ?string $version,
        public array $rightsList,
        public array $descriptions,
        public array $geoLocations,
        public array $fundingReferences,
        public ?string $xml,
        public string $url,
        public ?string $contentUrl,
        public int $metadataVersion,
        public ?string $schemaVersion,
        public string $source,
        public bool $isActive,
        public string $state,
        public ?string $reason,
        public int $viewCount,
        public array $viewsOverTime,
        public int $downloadCount,
        public array $downloadsOverTime,
        public int $referenceCount,
        public int $citationCount,
        public array $citationsOverTime,
        public int $partCount,
        public int $partOfCount,
        public int $versionCount,
        public int $versionOfCount,
        public DateTimeImmutable $created,
        public DateTimeImmutable $registered,
        public ?string $published,
        public DateTimeImmutable $updated,
        public RelationshipData $relationships,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['id']));
        assert(is_string($data['type']));
        assert(is_array($data['attributes']));
        assert(is_array($data['relationships']));

        $attributes = $data['attributes'];

        assert(is_string($attributes['doi']));
        assert(is_string($attributes['prefix']) || $attributes['prefix'] === null);
        assert(is_string($attributes['suffix']) || $attributes['suffix'] === null);
        assert(is_array($attributes['identifiers']));
        assert(is_array($attributes['alternateIdentifiers']) || $attributes['alternateIdentifiers'] === null);
        assert(is_array($attributes['creators']));
        assert(is_array($attributes['titles']));
        assert(is_array($attributes['container']));
        assert(is_numeric($attributes['publicationYear']));
        assert(is_array($attributes['subjects']));
        assert(is_array($attributes['contributors']));
        assert(is_array($attributes['dates']));
        assert(is_array($attributes['types']));
        assert(is_array($attributes['relatedIdentifiers']));
        assert(is_array($attributes['relatedItems']));
        assert(is_array($attributes['sizes']));
        assert(is_array($attributes['formats']));
        assert(is_array($attributes['rightsList']));
        assert(is_array($attributes['descriptions']));
        assert(is_array($attributes['geoLocations']));
        assert(is_array($attributes['fundingReferences']));
        assert(is_string($attributes['xml']) || $attributes['xml'] === null);
        assert(is_string($attributes['url']));
        assert(is_numeric($attributes['metadataVersion']));
        assert(is_string($attributes['schemaVersion']) || $attributes['schemaVersion'] === null);
        assert(is_string($attributes['source']));
        assert(is_bool($attributes['isActive']));
        assert(is_string($attributes['state']));
        assert(is_numeric($attributes['viewCount']));
        assert(is_array($attributes['viewsOverTime']) || ! array_key_exists('viewsOverTime', $attributes));
        assert(is_numeric($attributes['downloadCount']));
        assert(is_array($attributes['downloadsOverTime']) || ! array_key_exists('downloadsOverTime', $attributes));
        assert(is_numeric($attributes['referenceCount']));
        assert(is_array($attributes['citationsOverTime']) || ! array_key_exists('citationsOverTime', $attributes));
        assert(is_numeric($attributes['partCount']));
        assert(is_numeric($attributes['partOfCount']));
        assert(is_numeric($attributes['versionCount']));
        assert(is_numeric($attributes['versionOfCount']));
        assert(is_string($attributes['created']));
        assert(is_string($attributes['registered']));
        assert(is_string($attributes['published']) || $attributes['published'] === null);
        assert(is_string($attributes['updated']));

        /** @var array<array<string, mixed>> $identifiersData */
        $identifiersData = $attributes['identifiers'];
        /** @var array<array<string, mixed>> $alternateIdentifiersData */
        $alternateIdentifiersData = $attributes['alternateIdentifiers'] ?? [];
        /** @var array<array<string, mixed>> $creatorsData */
        $creatorsData = $attributes['creators'];
        /** @var array<array<string, mixed>> $titlesData */
        $titlesData = $attributes['titles'];
        /** @var array<string, mixed> $containerData */
        $containerData = $attributes['container'];
        /** @var array<array<string, mixed>> $subjectsData */
        $subjectsData = $attributes['subjects'];
        /** @var array<array<string, mixed>> $contributorsData */
        $contributorsData = $attributes['contributors'];
        /** @var array<array<string, mixed>> $datesData */
        $datesData = $attributes['dates'];
        /** @var array<string, mixed> $typesData */
        $typesData = $attributes['types'];
        /** @var array<array<string, mixed>> $relatedIdentifiersData */
        $relatedIdentifiersData = $attributes['relatedIdentifiers'];
        /** @var array<array<string, mixed>> $relatedItemsData */
        $relatedItemsData = $attributes['relatedItems'];
        /** @var array<string> $sizesData */
        $sizesData = $attributes['sizes'];
        /** @var array<string> $formatsData */
        $formatsData = $attributes['formats'];
        /** @var array<array<string, mixed>> $rightsListData */
        $rightsListData = $attributes['rightsList'];
        /** @var array<array<string, mixed>> $descriptionsData */
        $descriptionsData = $attributes['descriptions'];
        /** @var array<array<string, mixed>> $geoLocationsData */
        $geoLocationsData = $attributes['geoLocations'];
        /** @var array<array<string, mixed>> $fundingReferencesData */
        $fundingReferencesData = $attributes['fundingReferences'];
        /** @var array<string, int> $viewsOverTimeData */
        $viewsOverTimeData = $attributes['viewsOverTime'] ?? [];
        /** @var array<string, int> $downloadsOverTimeData */
        $downloadsOverTimeData = $attributes['downloadsOverTime'] ?? [];
        /** @var array<string, int> $citationsOverTimeData */
        $citationsOverTimeData = $attributes['citationsOverTime'] ?? [];
        /** @var array<string, mixed> $relationshipsData */
        $relationshipsData = $data['relationships'];

        $publisherData = null;
        if (is_array($attributes['publisher'])) {
            /** @var array<string, mixed> $publisherArray */
            $publisherArray = $attributes['publisher'];
            $publisherData = PublisherData::fromArray($publisherArray);
        }

        $creators = array_map(
            fn (array $item): Creator => Creator::fromArray($item),
            $creatorsData
        );
        assert($creators !== [], 'At least one creator is required');

        $titles = array_map(
            fn (array $item): Title => Title::fromArray($item),
            $titlesData
        );
        assert($titles !== [], 'At least one title is required');

        return new self(
            id: $data['id'],
            type: $data['type'],
            doi: $attributes['doi'],
            prefix: $attributes['prefix'] ?? null,
            suffix: $attributes['suffix'] ?? null,
            identifiers: array_map(
                fn (array $item): Identifier => Identifier::fromArray($item),
                $identifiersData
            ),
            alternateIdentifiers: array_map(
                fn (array $item): AlternateIdentifier => AlternateIdentifier::fromArray($item),
                $alternateIdentifiersData
            ),
            creators: $creators,
            titles: $titles,
            publisher: $publisherData ?? (is_string($attributes['publisher']) ? $attributes['publisher'] : ''),
            container: ContainerData::fromArray($containerData),
            publicationYear: (int) $attributes['publicationYear'],
            subjects: array_map(
                fn (array $item): Subject => Subject::fromArray($item),
                $subjectsData
            ),
            contributors: array_map(
                fn (array $item): Contributor => Contributor::fromArray($item),
                $contributorsData
            ),
            dates: array_map(
                fn (array $item): Date => Date::fromArray($item),
                $datesData
            ),
            language: isset($attributes['language']) && is_string($attributes['language']) ? $attributes['language'] : null,
            types: ResourceType::fromArray($typesData),
            relatedIdentifiers: array_map(
                fn (array $item): RelatedIdentifier => RelatedIdentifier::fromArray($item),
                $relatedIdentifiersData
            ),
            relatedItems: array_map(
                fn (array $item): RelatedItem => RelatedItem::fromArray($item),
                $relatedItemsData
            ),
            sizes: $sizesData,
            formats: $formatsData,
            version: isset($attributes['version']) && is_string($attributes['version']) ? $attributes['version'] : null,
            rightsList: array_map(
                fn (array $item): RightsList => RightsList::fromArray($item),
                $rightsListData
            ),
            descriptions: array_map(
                fn (array $item): Description => Description::fromArray($item),
                $descriptionsData
            ),
            geoLocations: array_map(
                fn (array $item): GeoLocation => GeoLocation::fromArray($item),
                $geoLocationsData
            ),
            fundingReferences: array_map(
                fn (array $item): FundingReference => FundingReference::fromArray($item),
                $fundingReferencesData
            ),
            xml: $attributes['xml'] ?? null,
            url: $attributes['url'],
            contentUrl: isset($attributes['contentUrl']) && is_string($attributes['contentUrl']) ? $attributes['contentUrl'] : null,
            metadataVersion: (int) $attributes['metadataVersion'],
            schemaVersion: $attributes['schemaVersion'] ?? null,
            source: $attributes['source'],
            isActive: $attributes['isActive'],
            state: $attributes['state'],
            reason: isset($attributes['reason']) && is_string($attributes['reason']) ? $attributes['reason'] : null,
            viewCount: (int) $attributes['viewCount'],
            viewsOverTime: $viewsOverTimeData,
            downloadCount: isset($attributes['downloadCount']) ? (int) $attributes['downloadCount'] : 0,
            downloadsOverTime: $downloadsOverTimeData,
            referenceCount: isset($attributes['referenceCount']) ? (int) $attributes['referenceCount'] : 0,
            citationCount: isset($attributes['citationCount']) && is_numeric($attributes['citationCount']) ? (int) $attributes['citationCount'] : 0,
            citationsOverTime: $citationsOverTimeData,
            partCount: (int) $attributes['partCount'],
            partOfCount: (int) $attributes['partOfCount'],
            versionCount: (int) $attributes['versionCount'],
            versionOfCount: (int) $attributes['versionOfCount'],
            created: new DateTimeImmutable($attributes['created']),
            registered: new DateTimeImmutable($attributes['registered']),
            published: $attributes['published'] ?? null,
            updated: new DateTimeImmutable($attributes['updated']),
            relationships: RelationshipData::fromArray($relationshipsData),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $attributes = [
            'doi' => $this->doi,
            'creators' => array_map(fn (Creator $creator): array => $creator->toArray(), $this->creators),
            'titles' => array_map(fn (Title $title): array => $title->toArray(), $this->titles),
            'publisher' => $this->publisher instanceof PublisherData
                ? $this->publisher->toArray()
                : $this->publisher,
            'publicationYear' => $this->publicationYear,
            'types' => $this->types->toArray(),
        ];

        if ($this->url !== '' && $this->url !== '0') {
            $attributes['url'] = $this->url;
        }

        if ($this->prefix !== '' && $this->prefix !== '0') {
            $attributes['prefix'] = $this->prefix;
        }

        if ($this->suffix !== '' && $this->suffix !== '0') {
            $attributes['suffix'] = $this->suffix;
        }

        if (count($this->identifiers) > 0) {
            $attributes['identifiers'] = array_map(
                fn (Identifier $identifier): array => $identifier->toArray(),
                $this->identifiers
            );
        }

        if (count($this->alternateIdentifiers) > 0) {
            $attributes['alternateIdentifiers'] = array_map(
                fn (AlternateIdentifier $identifier): array => $identifier->toArray(),
                $this->alternateIdentifiers
            );
        }

        if (count($this->subjects) > 0) {
            $attributes['subjects'] = array_map(
                fn (Subject $subject): array => $subject->toArray(),
                $this->subjects
            );
        }

        if (count($this->contributors) > 0) {
            $attributes['contributors'] = array_map(
                fn (Contributor $contributor): array => $contributor->toArray(),
                $this->contributors
            );
        }

        if (count($this->dates) > 0) {
            $attributes['dates'] = array_map(
                fn (Date $date): array => $date->toArray(),
                $this->dates
            );
        }

        if ($this->language !== null) {
            $attributes['language'] = $this->language;
        }

        if (count($this->relatedIdentifiers) > 0) {
            $attributes['relatedIdentifiers'] = array_map(
                fn (RelatedIdentifier $identifier): array => $identifier->toArray(),
                $this->relatedIdentifiers
            );
        }

        if (count($this->relatedItems) > 0) {
            $attributes['relatedItems'] = array_map(
                fn (RelatedItem $item): array => $item->toArray(),
                $this->relatedItems
            );
        }

        if (count($this->sizes) > 0) {
            $attributes['sizes'] = $this->sizes;
        }

        if (count($this->formats) > 0) {
            $attributes['formats'] = $this->formats;
        }

        if ($this->version !== null) {
            $attributes['version'] = $this->version;
        }

        if (count($this->rightsList) > 0) {
            $attributes['rightsList'] = array_map(
                fn (RightsList $rights): array => $rights->toArray(),
                $this->rightsList
            );
        }

        if (count($this->descriptions) > 0) {
            $attributes['descriptions'] = array_map(
                fn (Description $description): array => $description->toArray(),
                $this->descriptions
            );
        }

        if (count($this->geoLocations) > 0) {
            $attributes['geoLocations'] = array_map(
                fn (GeoLocation $geoLocation): array => $geoLocation->toArray(),
                $this->geoLocations
            );
        }

        if (count($this->fundingReferences) > 0) {
            $attributes['fundingReferences'] = array_map(
                fn (FundingReference $reference): array => $reference->toArray(),
                $this->fundingReferences
            );
        }

        if ($this->schemaVersion !== '' && $this->schemaVersion !== '0') {
            $attributes['schemaVersion'] = $this->schemaVersion;
        }

        $container = $this->container->toArray();
        if (count($container) > 0) {
            $attributes['container'] = $container;
        }

        return [
            'data' => [
                'type' => 'dois',
                'attributes' => $attributes,
            ],
        ];
    }
}
