<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

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

/**
 * Input DTO for creating  DOI metadata.
 * All fields are optional to support both full creates and partial updates.
 * DataCite API will validate mandatory fields based on operation type.
 */
final readonly class CreateDOIInput
{
    /**
     * @param  array<Creator>  $creators
     * @param  array<Title>  $titles
     * @param  array<Identifier>|null  $identifiers
     * @param  array<AlternateIdentifier>|null  $alternateIdentifiers
     * @param  array<Subject>|null  $subjects
     * @param  array<Contributor>|null  $contributors
     * @param  array<Date>|null  $dates
     * @param  array<RelatedIdentifier>|null  $relatedIdentifiers
     * @param  array<RelatedItem>|null  $relatedItems
     * @param  array<string>|null  $sizes
     * @param  array<string>|null  $formats
     * @param  array<RightsList>|null  $rightsList
     * @param  array<Description>|null  $descriptions
     * @param  array<GeoLocation>|null  $geoLocations
     * @param  array<FundingReference>|null  $fundingReferences
     */
    public function __construct(
        public string $prefix,
        public array $creators,
        public array $titles,
        public int $publicationYear,
        public PublisherData|string $publisher,
        public TypeData $types,
        public string $url,
        public ?string $event = null, // when not set, a draft DOI is created
        public ?string $doi = null,
        public ?array $identifiers = null,
        public ?array $alternateIdentifiers = null,
        public ?ContainerData $container = null,
        public ?array $subjects = null,
        public ?array $contributors = null,
        public ?array $dates = null,
        public ?string $language = null,
        public ?array $relatedIdentifiers = null,
        public ?array $relatedItems = null,
        public ?array $sizes = null,
        public ?array $formats = null,
        public ?string $version = null,
        public ?array $rightsList = null,
        public ?array $descriptions = null,
        public ?array $geoLocations = null,
        public ?array $fundingReferences = null,
        public ?string $contentUrl = null,
        public ?string $schemaVersion = null,
    ) {}

    /**
     * Convert to array for API submission, excluding null values.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->event !== null) {
            $data['event'] = $this->event;
        }

        $data['prefix'] = $this->prefix;

        if ($this->doi !== null) {
            $data['doi'] = $this->doi;
        }

        if ($this->identifiers !== null) {
            $data['identifiers'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Identifiers\Identifier $item): array => $item->toArray(), $this->identifiers);
        }

        if ($this->alternateIdentifiers !== null) {
            $data['alternateIdentifiers'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Identifiers\AlternateIdentifier $item): array => $item->toArray(), $this->alternateIdentifiers);
        }

        $data['creators'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Metadata\Creator $item): array => $item->toArray(), $this->creators);

        $data['titles'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Metadata\Title $item): array => $item->toArray(), $this->titles);

        $data['publisher'] = is_string($this->publisher) ? $this->publisher : $this->publisher->toArray();

        if ($this->container instanceof \VincentAuger\DataCiteSdk\Data\Metadata\ContainerData) {
            $data['container'] = $this->container->toArray();
        }

        $data['publicationYear'] = $this->publicationYear;

        if ($this->subjects !== null) {
            $data['subjects'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Metadata\Subject $item): array => $item->toArray(), $this->subjects);
        }

        if ($this->contributors !== null) {
            $data['contributors'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Metadata\Contributor $item): array => $item->toArray(), $this->contributors);
        }

        if ($this->dates !== null) {
            $data['dates'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Metadata\Date $item): array => $item->toArray(), $this->dates);
        }

        if ($this->language !== null) {
            $data['language'] = $this->language;
        }

        $data['types'] = $this->types->toArray();

        if ($this->relatedIdentifiers !== null) {
            $data['relatedIdentifiers'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Identifiers\RelatedIdentifier $item): array => $item->toArray(), $this->relatedIdentifiers);
        }

        if ($this->relatedItems !== null) {
            $data['relatedItems'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Identifiers\RelatedItem $item): array => $item->toArray(), $this->relatedItems);
        }

        if ($this->sizes !== null) {
            $data['sizes'] = $this->sizes;
        }

        if ($this->formats !== null) {
            $data['formats'] = $this->formats;
        }

        if ($this->version !== null) {
            $data['version'] = $this->version;
        }

        if ($this->rightsList !== null) {
            $data['rightsList'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Metadata\RightsList $item): array => $item->toArray(), $this->rightsList);
        }

        if ($this->descriptions !== null) {
            $data['descriptions'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Metadata\Description $item): array => $item->toArray(), $this->descriptions);
        }

        if ($this->geoLocations !== null) {
            $data['geoLocations'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\GeoLocation\GeoLocation $item): array => $item->toArray(), $this->geoLocations);
        }

        if ($this->fundingReferences !== null) {
            $data['fundingReferences'] = array_map(fn (\VincentAuger\DataCiteSdk\Data\Metadata\FundingReference $item): array => $item->toArray(), $this->fundingReferences);
        }

        $data['url'] = $this->url;

        if ($this->contentUrl !== null) {
            $data['contentUrl'] = $this->contentUrl;
        }

        if ($this->schemaVersion !== null) {
            $data['schemaVersion'] = $this->schemaVersion;
        }

        return $data;
    }
}
