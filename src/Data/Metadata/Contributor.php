<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Data\Identifiers\NameIdentifier;

final readonly class Contributor
{
    /**
     * @param  string[]  $affiliation
     * @param  NameIdentifier[]  $nameIdentifiers
     */
    public function __construct(
        public string $name,
        public ?string $nameType,
        public ?string $givenName,
        public ?string $familyName,
        public array $affiliation,
        public string $contributorType,
        public array $nameIdentifiers,
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

        /** @var array<string> $affiliationData */
        $affiliationData = $data['affiliation'];
        /** @var array<array<string, mixed>> $nameIdentifiersData */
        $nameIdentifiersData = $data['nameIdentifiers'];

        return new self(
            name: $data['name'],
            nameType: isset($data['nameType']) && is_string($data['nameType']) ? $data['nameType'] : null,
            givenName: isset($data['givenName']) && is_string($data['givenName']) ? $data['givenName'] : null,
            familyName: isset($data['familyName']) && is_string($data['familyName']) ? $data['familyName'] : null,
            affiliation: $affiliationData,
            contributorType: $data['contributorType'],
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

        if (count($this->affiliation) > 0) {
            $array['affiliation'] = $this->affiliation;
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
