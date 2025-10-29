<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Data\Affiliations\Affiliation;
use VincentAuger\DataCiteSdk\Data\Identifiers\NameIdentifier;

final readonly class Contributor
{
    /**
     * @param  Affiliation[]|null  $affiliation
     * @param  NameIdentifier[]|null  $nameIdentifiers
     */
    public function __construct(
        public string $name,
        public string $contributorType,
        public ?string $nameType = null,
        public ?string $givenName = null,
        public ?string $familyName = null,
        public ?array $affiliation = null,
        public ?array $nameIdentifiers = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['name']));
        assert(is_array($data['affiliation']));
        assert(is_string($data['contributorType']));
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

        return new self(
            name: $data['name'],
            contributorType: $data['contributorType'],
            nameType: isset($data['nameType']) && is_string($data['nameType']) ? $data['nameType'] : null,
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
        $array = [
            'name' => $this->name,
            'contributorType' => $this->contributorType,
        ];

        if ($this->nameType !== null) {
            $array['nameType'] = $this->nameType;
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
