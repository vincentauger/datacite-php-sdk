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
use VincentAuger\DataCiteSdk\Data\Metadata\RightsList;
use VincentAuger\DataCiteSdk\Data\Metadata\Subject;
use VincentAuger\DataCiteSdk\Data\Metadata\Title;
use VincentAuger\DataCiteSdk\Data\Metadata\TypeData;
use VincentAuger\DataCiteSdk\Data\Relationships\RelationshipData;

final readonly class DOIData
{
    /**
     * @param  Creator[]  $creators
     * @param  Title[]  $titles
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
        public string $doi,
        public string $prefix,
        public string $suffix,
        public array $identifiers,
        public array $alternateIdentifiers,
        public array $creators,
        public array $titles,
        public PublisherData|string $publisher,
        public ContainerData $container,
        public int $publicationYear,
        public array $subjects,
        public array $contributors,
        public array $dates,
        public ?string $language,
        public TypeData $types,
        public array $relatedIdentifiers,
        public array $relatedItems,
        public array $sizes,
        public array $formats,
        public ?string $version,
        public array $rightsList,
        public array $descriptions,
        public array $geoLocations,
        public array $fundingReferences,
        public string $xml,
        public string $url,
        public ?string $contentUrl,
        public int $metadataVersion,
        public string $schemaVersion,
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
        public string $published,
        public DateTimeImmutable $updated,
        public RelationshipData $relationships,
    ) {}

    public static function fromArray(array $data): self
    {
        $attributes = $data['attributes'];

        return new self(
            id: $data['id'],
            type: $data['type'],
            doi: $attributes['doi'],
            prefix: $attributes['prefix'],
            suffix: $attributes['suffix'],
            identifiers: array_map(
                fn (array $item) => Identifier::fromArray($item),
                $attributes['identifiers']
            ),
            alternateIdentifiers: array_map(
                fn (array $item) => AlternateIdentifier::fromArray($item),
                $attributes['alternateIdentifiers']
            ),
            creators: array_map(
                fn (array $item) => Creator::fromArray($item),
                $attributes['creators']
            ),
            titles: array_map(
                fn (array $item) => Title::fromArray($item),
                $attributes['titles']
            ),
            publisher: is_array($attributes['publisher'])
                ? PublisherData::fromArray($attributes['publisher'])
                : $attributes['publisher'],
            container: ContainerData::fromArray($attributes['container']),
            publicationYear: $attributes['publicationYear'],
            subjects: array_map(
                fn (array $item) => Subject::fromArray($item),
                $attributes['subjects']
            ),
            contributors: array_map(
                fn (array $item) => Contributor::fromArray($item),
                $attributes['contributors']
            ),
            dates: array_map(
                fn (array $item) => Date::fromArray($item),
                $attributes['dates']
            ),
            language: $attributes['language'],
            types: TypeData::fromArray($attributes['types']),
            relatedIdentifiers: array_map(
                fn (array $item) => RelatedIdentifier::fromArray($item),
                $attributes['relatedIdentifiers']
            ),
            relatedItems: array_map(
                fn (array $item) => RelatedItem::fromArray($item),
                $attributes['relatedItems']
            ),
            sizes: $attributes['sizes'],
            formats: $attributes['formats'],
            version: $attributes['version'],
            rightsList: array_map(
                fn (array $item) => RightsList::fromArray($item),
                $attributes['rightsList']
            ),
            descriptions: array_map(
                fn (array $item) => Description::fromArray($item),
                $attributes['descriptions']
            ),
            geoLocations: array_map(
                fn (array $item) => GeoLocation::fromArray($item),
                $attributes['geoLocations']
            ),
            fundingReferences: array_map(
                fn (array $item) => FundingReference::fromArray($item),
                $attributes['fundingReferences']
            ),
            xml: $attributes['xml'],
            url: $attributes['url'],
            contentUrl: $attributes['contentUrl'],
            metadataVersion: $attributes['metadataVersion'],
            schemaVersion: $attributes['schemaVersion'],
            source: $attributes['source'],
            isActive: $attributes['isActive'],
            state: $attributes['state'],
            reason: $attributes['reason'],
            viewCount: $attributes['viewCount'],
            viewsOverTime: $attributes['viewsOverTime'],
            downloadCount: $attributes['downloadCount'],
            downloadsOverTime: $attributes['downloadsOverTime'],
            referenceCount: $attributes['referenceCount'],
            citationCount: $attributes['citationCount'],
            citationsOverTime: $attributes['citationsOverTime'],
            partCount: $attributes['partCount'],
            partOfCount: $attributes['partOfCount'],
            versionCount: $attributes['versionCount'],
            versionOfCount: $attributes['versionOfCount'],
            created: new DateTimeImmutable($attributes['created']),
            registered: new DateTimeImmutable($attributes['registered']),
            published: $attributes['published'],
            updated: new DateTimeImmutable($attributes['updated']),
            relationships: RelationshipData::fromArray($data['relationships']),
        );
    }

    public function toArray(): array
    {
        $attributes = [
            'doi' => $this->doi,
            'creators' => array_map(fn (Creator $creator) => $creator->toArray(), $this->creators),
            'titles' => array_map(fn (Title $title) => $title->toArray(), $this->titles),
            'publisher' => $this->publisher instanceof PublisherData
                ? $this->publisher->toArray()
                : $this->publisher,
            'publicationYear' => $this->publicationYear,
            'types' => $this->types->toArray(),
        ];

        if ($this->url) {
            $attributes['url'] = $this->url;
        }

        if ($this->prefix) {
            $attributes['prefix'] = $this->prefix;
        }

        if ($this->suffix) {
            $attributes['suffix'] = $this->suffix;
        }

        if (count($this->identifiers) > 0) {
            $attributes['identifiers'] = array_map(
                fn (Identifier $identifier) => $identifier->toArray(),
                $this->identifiers
            );
        }

        if (count($this->alternateIdentifiers) > 0) {
            $attributes['alternateIdentifiers'] = array_map(
                fn (AlternateIdentifier $identifier) => $identifier->toArray(),
                $this->alternateIdentifiers
            );
        }

        if (count($this->subjects) > 0) {
            $attributes['subjects'] = array_map(
                fn (Subject $subject) => $subject->toArray(),
                $this->subjects
            );
        }

        if (count($this->contributors) > 0) {
            $attributes['contributors'] = array_map(
                fn (Contributor $contributor) => $contributor->toArray(),
                $this->contributors
            );
        }

        if (count($this->dates) > 0) {
            $attributes['dates'] = array_map(
                fn (Date $date) => $date->toArray(),
                $this->dates
            );
        }

        if ($this->language !== null) {
            $attributes['language'] = $this->language;
        }

        if (count($this->relatedIdentifiers) > 0) {
            $attributes['relatedIdentifiers'] = array_map(
                fn (RelatedIdentifier $identifier) => $identifier->toArray(),
                $this->relatedIdentifiers
            );
        }

        if (count($this->relatedItems) > 0) {
            $attributes['relatedItems'] = array_map(
                fn (RelatedItem $item) => $item->toArray(),
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
                fn (RightsList $rights) => $rights->toArray(),
                $this->rightsList
            );
        }

        if (count($this->descriptions) > 0) {
            $attributes['descriptions'] = array_map(
                fn (Description $description) => $description->toArray(),
                $this->descriptions
            );
        }

        if (count($this->geoLocations) > 0) {
            $attributes['geoLocations'] = array_map(
                fn (GeoLocation $geoLocation) => $geoLocation->toArray(),
                $this->geoLocations
            );
        }

        if (count($this->fundingReferences) > 0) {
            $attributes['fundingReferences'] = array_map(
                fn (FundingReference $reference) => $reference->toArray(),
                $this->fundingReferences
            );
        }

        if ($this->schemaVersion) {
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
