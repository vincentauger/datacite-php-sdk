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
 * Input DTO for creating or updating DOI metadata.
 * All fields are optional to support both full creates and partial updates.
 * DataCite API will validate mandatory fields based on operation type.
 */
final readonly class DOIInput
{
    /**
     * @param  array<Creator>|null  $creators
     * @param  array<Title>|null  $titles
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
        public ?string $doi = null,
        public ?array $identifiers = null,
        public ?array $alternateIdentifiers = null,
        public ?array $creators = null,
        public ?array $titles = null,
        public PublisherData|string|null $publisher = null,
        public ?ContainerData $container = null,
        public ?int $publicationYear = null,
        public ?array $subjects = null,
        public ?array $contributors = null,
        public ?array $dates = null,
        public ?string $language = null,
        public ?TypeData $types = null,
        public ?array $relatedIdentifiers = null,
        public ?array $relatedItems = null,
        public ?array $sizes = null,
        public ?array $formats = null,
        public ?string $version = null,
        public ?array $rightsList = null,
        public ?array $descriptions = null,
        public ?array $geoLocations = null,
        public ?array $fundingReferences = null,
        public ?string $url = null,
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

        if ($this->doi !== null) {
            $data['doi'] = $this->doi;
        }

        if ($this->identifiers !== null) {
            $data['identifiers'] = array_map(fn ($item) => $item->toArray(), $this->identifiers);
        }

        if ($this->alternateIdentifiers !== null) {
            $data['alternateIdentifiers'] = array_map(fn ($item) => $item->toArray(), $this->alternateIdentifiers);
        }

        if ($this->creators !== null) {
            $data['creators'] = array_map(fn ($item) => $item->toArray(), $this->creators);
        }

        if ($this->titles !== null) {
            $data['titles'] = array_map(fn ($item) => $item->toArray(), $this->titles);
        }

        if ($this->publisher !== null) {
            $data['publisher'] = is_string($this->publisher) ? $this->publisher : $this->publisher->toArray();
        }

        if ($this->container !== null) {
            $data['container'] = $this->container->toArray();
        }

        if ($this->publicationYear !== null) {
            $data['publicationYear'] = $this->publicationYear;
        }

        if ($this->subjects !== null) {
            $data['subjects'] = array_map(fn ($item) => $item->toArray(), $this->subjects);
        }

        if ($this->contributors !== null) {
            $data['contributors'] = array_map(fn ($item) => $item->toArray(), $this->contributors);
        }

        if ($this->dates !== null) {
            $data['dates'] = array_map(fn ($item) => $item->toArray(), $this->dates);
        }

        if ($this->language !== null) {
            $data['language'] = $this->language;
        }

        if ($this->types !== null) {
            $data['types'] = $this->types->toArray();
        }

        if ($this->relatedIdentifiers !== null) {
            $data['relatedIdentifiers'] = array_map(fn ($item) => $item->toArray(), $this->relatedIdentifiers);
        }

        if ($this->relatedItems !== null) {
            $data['relatedItems'] = array_map(fn ($item) => $item->toArray(), $this->relatedItems);
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
            $data['rightsList'] = array_map(fn ($item) => $item->toArray(), $this->rightsList);
        }

        if ($this->descriptions !== null) {
            $data['descriptions'] = array_map(fn ($item) => $item->toArray(), $this->descriptions);
        }

        if ($this->geoLocations !== null) {
            $data['geoLocations'] = array_map(fn ($item) => $item->toArray(), $this->geoLocations);
        }

        if ($this->fundingReferences !== null) {
            $data['fundingReferences'] = array_map(fn ($item) => $item->toArray(), $this->fundingReferences);
        }

        if ($this->url !== null) {
            $data['url'] = $this->url;
        }

        if ($this->contentUrl !== null) {
            $data['contentUrl'] = $this->contentUrl;
        }

        if ($this->schemaVersion !== null) {
            $data['schemaVersion'] = $this->schemaVersion;
        }

        return $data;
    }
}
