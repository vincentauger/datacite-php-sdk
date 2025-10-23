<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class RelatedItemCreator
{
    public function __construct(
        public string $creatorName,
        public ?string $nameType = null,
        public ?string $lang = null,
        public ?string $givenName = null,
        public ?string $familyName = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['creatorName']));

        return new self(
            creatorName: $data['creatorName'],
            nameType: isset($data['nameType']) && is_string($data['nameType']) ? $data['nameType'] : null,
            lang: isset($data['lang']) && is_string($data['lang']) ? $data['lang'] : null,
            givenName: isset($data['givenName']) && is_string($data['givenName']) ? $data['givenName'] : null,
            familyName: isset($data['familyName']) && is_string($data['familyName']) ? $data['familyName'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = ['creatorName' => $this->creatorName];

        if ($this->nameType !== null) {
            $array['nameType'] = $this->nameType;
        }

        if ($this->lang !== null) {
            $array['lang'] = $this->lang;
        }

        if ($this->givenName !== null) {
            $array['givenName'] = $this->givenName;
        }

        if ($this->familyName !== null) {
            $array['familyName'] = $this->familyName;
        }

        return $array;
    }
}
