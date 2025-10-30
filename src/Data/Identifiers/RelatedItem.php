<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

use VincentAuger\DataCiteSdk\Data\Metadata\Title;
use VincentAuger\DataCiteSdk\Enums\RelationType;
use VincentAuger\DataCiteSdk\Enums\ResourceTypeGeneral;

/**
 * Information about a resource related to the one being registered.
 *
 * Note: The properties relatedMetadataScheme, schemeURI, and schemeType in RelatedItemIdentifier
 * should only be used when relationType is HasMetadata or IsMetadataFor.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/properties/relateditem/
 */
final readonly class RelatedItem
{
    /**
     * @param  Title[]  $titles
     * @param  RelatedItemCreator[]  $creators
     * @param  RelatedItemContributor[]  $contributors
     */
    public function __construct(
        public array $titles,
        public RelationType $relationType,
        public ResourceTypeGeneral $relatedItemType,
        public ?RelatedItemIdentifier $relatedItemIdentifier = null,
        public array $creators = [],
        public ?int $publicationYear = null,
        public ?string $volume = null,
        public ?string $issue = null,
        public ?string $number = null,
        public ?string $numberType = null,
        public ?string $firstPage = null,
        public ?string $lastPage = null,
        public ?string $publisher = null,
        public ?string $edition = null,
        public array $contributors = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_array($data['titles']));
        assert(is_string($data['relationType']) || $data['relationType'] instanceof RelationType);
        assert(is_string($data['relatedItemType']) || $data['relatedItemType'] instanceof ResourceTypeGeneral);

        /** @var array<array<string, mixed>> $titlesData */
        $titlesData = $data['titles'];

        $relatedItemIdentifierData = null;
        if (isset($data['relatedItemIdentifier']) && is_array($data['relatedItemIdentifier'])) {
            /** @var array<string, mixed> $identifierArray */
            $identifierArray = $data['relatedItemIdentifier'];
            $relatedItemIdentifierData = RelatedItemIdentifier::fromArray($identifierArray);
        }

        $creatorsData = [];
        if (isset($data['creators']) && is_array($data['creators'])) {
            /** @var array<array<string, mixed>> $creatorsArray */
            $creatorsArray = $data['creators'];
            $creatorsData = array_map(
                fn (array $item): RelatedItemCreator => RelatedItemCreator::fromArray($item),
                $creatorsArray
            );
        }

        $contributorsData = [];
        if (isset($data['contributors']) && is_array($data['contributors'])) {
            /** @var array<array<string, mixed>> $contributorsArray */
            $contributorsArray = $data['contributors'];
            $contributorsData = array_map(
                fn (array $item): RelatedItemContributor => RelatedItemContributor::fromArray($item),
                $contributorsArray
            );
        }

        return new self(
            titles: array_map(
                fn (array $item): Title => Title::fromArray($item),
                $titlesData
            ),
            relationType: $data['relationType'] instanceof RelationType ? $data['relationType'] : RelationType::from($data['relationType']),
            relatedItemType: $data['relatedItemType'] instanceof ResourceTypeGeneral ? $data['relatedItemType'] : ResourceTypeGeneral::from($data['relatedItemType']),
            relatedItemIdentifier: $relatedItemIdentifierData,
            creators: $creatorsData,
            publicationYear: isset($data['publicationYear']) && is_numeric($data['publicationYear']) ? (int) $data['publicationYear'] : null,
            volume: isset($data['volume']) && is_string($data['volume']) ? $data['volume'] : null,
            issue: isset($data['issue']) && is_string($data['issue']) ? $data['issue'] : null,
            number: isset($data['number']) && is_string($data['number']) ? $data['number'] : null,
            numberType: isset($data['numberType']) && is_string($data['numberType']) ? $data['numberType'] : null,
            firstPage: isset($data['firstPage']) && is_string($data['firstPage']) ? $data['firstPage'] : null,
            lastPage: isset($data['lastPage']) && is_string($data['lastPage']) ? $data['lastPage'] : null,
            publisher: isset($data['publisher']) && is_string($data['publisher']) ? $data['publisher'] : null,
            edition: isset($data['edition']) && is_string($data['edition']) ? $data['edition'] : null,
            contributors: $contributorsData,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'titles' => array_map(fn (Title $title): array => $title->toArray(), $this->titles),
            'relationType' => $this->relationType->value,
            'relatedItemType' => $this->relatedItemType->value,
        ];

        if ($this->relatedItemIdentifier instanceof \VincentAuger\DataCiteSdk\Data\Identifiers\RelatedItemIdentifier) {
            $identifierArray = $this->relatedItemIdentifier->toArray();

            // Validate that relatedMetadataScheme, schemeURI, and schemeType are only used with HasMetadata/IsMetadataFor
            $isMetadataRelation = $this->relationType === RelationType::HAS_METADATA
                || $this->relationType === RelationType::IS_METADATA_FOR;

            if (! $isMetadataRelation) {
                // Remove metadata scheme properties if they exist but shouldn't be used
                unset($identifierArray['relatedMetadataScheme'], $identifierArray['schemeURI'], $identifierArray['schemeType']);
            }

            $array['relatedItemIdentifier'] = $identifierArray;
        }

        if (count($this->creators) > 0) {
            $array['creators'] = array_map(
                fn (RelatedItemCreator $creator): array => $creator->toArray(),
                $this->creators
            );
        }

        if ($this->publicationYear !== null) {
            $array['publicationYear'] = $this->publicationYear;
        }

        if ($this->volume !== null) {
            $array['volume'] = $this->volume;
        }

        if ($this->issue !== null) {
            $array['issue'] = $this->issue;
        }

        if ($this->number !== null) {
            $array['number'] = $this->number;
        }

        if ($this->numberType !== null) {
            $array['numberType'] = $this->numberType;
        }

        if ($this->firstPage !== null) {
            $array['firstPage'] = $this->firstPage;
        }

        if ($this->lastPage !== null) {
            $array['lastPage'] = $this->lastPage;
        }

        if ($this->publisher !== null) {
            $array['publisher'] = $this->publisher;
        }

        if ($this->edition !== null) {
            $array['edition'] = $this->edition;
        }

        if (count($this->contributors) > 0) {
            $array['contributors'] = array_map(
                fn (RelatedItemContributor $contributor): array => $contributor->toArray(),
                $this->contributors
            );
        }

        return $array;
    }
}
