<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Data\Affiliations\Affiliation;
use VincentAuger\DataCiteSdk\Data\Identifiers\NameIdentifier;
use VincentAuger\DataCiteSdk\Enums\NameType;

final readonly class Creator
{
    /**
     * @param  Affiliation[]|null  $affiliation
     * @param  NameIdentifier[]|null  $nameIdentifiers
     */
    public function __construct(
        public string $name,
        public ?NameType $nameType = null,
        public ?string $givenName = null,
        public ?string $familyName = null,
        public ?array $affiliation = null,
        public ?array $nameIdentifiers = null,
    ) {}

    /**
     * Create from array, lenient parsing for API responses.
     * Returns null if required name field is missing.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): ?self
    {
        // Skip invalid creators from API responses (legacy/incomplete data)
        if (! isset($data['name']) || ! is_string($data['name']) || $data['name'] === '') {
            return null;
        }

        assert(is_array($data['affiliation']));
        assert(is_array($data['nameIdentifiers']));

        /** @var array<array<string, mixed>> $nameIdentifiersData */
        $nameIdentifiersData = $data['nameIdentifiers'];

        $affiliations = array_map(
            function (mixed $item): Affiliation {
                if (is_array($item)) {
                    /** @var array<string, mixed> $affiliationArray */
                    $affiliationArray = $item;

                    return Affiliation::fromArray($affiliationArray);
                }

                return new Affiliation(is_string($item) ? $item : '', null, null, null);
            },
            $data['affiliation']
        );

        $nameType = isset($data['nameType']) && is_string($data['nameType']) ? NameType::from($data['nameType']) : null;

        return new self(
            name: $data['name'],
            nameType: $nameType,
            givenName: isset($data['givenName']) && is_string($data['givenName']) ? $data['givenName'] : null,
            familyName: isset($data['familyName']) && is_string($data['familyName']) ? $data['familyName'] : null,
            affiliation: $affiliations,
            nameIdentifiers: array_map(
                fn (array $item): NameIdentifier => NameIdentifier::fromArray($item),
                $nameIdentifiersData
            ),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = ['name' => $this->name];

        if ($this->nameType instanceof \VincentAuger\DataCiteSdk\Enums\NameType) {
            $array['nameType'] = $this->nameType->value;
        }

        if ($this->givenName !== null) {
            $array['givenName'] = $this->givenName;
        }

        if ($this->familyName !== null) {
            $array['familyName'] = $this->familyName;
        }

        if ($this->affiliation !== null && count($this->affiliation) > 0) {
            $array['affiliation'] = array_map(
                fn (Affiliation $affiliation): array => $affiliation->toArray(),
                $this->affiliation
            );
        }

        if ($this->nameIdentifiers !== null && count($this->nameIdentifiers) > 0) {
            $array['nameIdentifiers'] = array_map(
                fn (NameIdentifier $nameIdentifier): array => $nameIdentifier->toArray(),
                $this->nameIdentifiers
            );
        }

        return $array;
    }
}
