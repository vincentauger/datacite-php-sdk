<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Data\Affiliations\Affiliation;
use VincentAuger\DataCiteSdk\Data\Identifiers\NameIdentifier;

final readonly class Creator
{
    /**
     * @param  Affiliation[]  $affiliation
     * @param  NameIdentifier[]  $nameIdentifiers
     */
    public function __construct(
        public string $name,
        public ?string $nameType,
        public ?string $givenName,
        public ?string $familyName,
        public array $affiliation,
        public array $nameIdentifiers,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['name']));
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

        return new self(
            name: $data['name'],
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
        $array = ['name' => $this->name];

        if ($this->nameType !== null) {
            $array['nameType'] = $this->nameType;
        }

        if ($this->givenName !== null) {
            $array['givenName'] = $this->givenName;
        }

        if ($this->familyName !== null) {
            $array['familyName'] = $this->familyName;
        }

        if (count($this->affiliation) > 0) {
            $array['affiliation'] = array_map(
                fn (Affiliation $affiliation): array => $affiliation->toArray(),
                $this->affiliation
            );
        }

        if (count($this->nameIdentifiers) > 0) {
            $array['nameIdentifiers'] = array_map(
                fn (NameIdentifier $nameIdentifier): array => $nameIdentifier->toArray(),
                $this->nameIdentifiers
            );
        }

        return $array;
    }
}
