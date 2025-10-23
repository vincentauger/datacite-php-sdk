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

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            nameType: $data['nameType'] ?? null,
            givenName: $data['givenName'] ?? null,
            familyName: $data['familyName'] ?? null,
            affiliation: array_map(
                fn (array|string $item) => is_array($item) ? Affiliation::fromArray($item) : new Affiliation($item, null, null, null),
                $data['affiliation']
            ),
            nameIdentifiers: array_map(
                fn (array $item) => NameIdentifier::fromArray($item),
                $data['nameIdentifiers']
            ),
        );
    }

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
                fn (Affiliation $affiliation) => $affiliation->toArray(),
                $this->affiliation
            );
        }

        if (count($this->nameIdentifiers) > 0) {
            $array['nameIdentifiers'] = array_map(
                fn (NameIdentifier $nameIdentifier) => $nameIdentifier->toArray(),
                $this->nameIdentifiers
            );
        }

        return $array;
    }
}
