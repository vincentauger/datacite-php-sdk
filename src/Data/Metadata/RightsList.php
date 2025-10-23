<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class RightsList
{
    public function __construct(
        public string $rights,
        public ?string $lang = null,
        public ?string $rightsUri = null,
        public ?string $rightsIdentifier = null,
        public ?string $rightsIdentifierScheme = null,
        public ?string $schemeUri = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['rights']));

        return new self(
            rights: $data['rights'],
            lang: isset($data['lang']) && is_string($data['lang']) ? $data['lang'] : null,
            rightsUri: isset($data['rightsUri']) && is_string($data['rightsUri']) ? $data['rightsUri'] : null,
            rightsIdentifier: isset($data['rightsIdentifier']) && is_string($data['rightsIdentifier']) ? $data['rightsIdentifier'] : null,
            rightsIdentifierScheme: isset($data['rightsIdentifierScheme']) && is_string($data['rightsIdentifierScheme']) ? $data['rightsIdentifierScheme'] : null,
            schemeUri: isset($data['schemeUri']) && is_string($data['schemeUri']) ? $data['schemeUri'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = ['rights' => $this->rights];

        if ($this->lang !== null) {
            $array['lang'] = $this->lang;
        }

        if ($this->rightsUri !== null) {
            $array['rightsUri'] = $this->rightsUri;
        }

        if ($this->rightsIdentifier !== null) {
            $array['rightsIdentifier'] = $this->rightsIdentifier;
        }

        if ($this->rightsIdentifierScheme !== null) {
            $array['rightsIdentifierScheme'] = $this->rightsIdentifierScheme;
        }

        if ($this->schemeUri !== null) {
            $array['schemeUri'] = $this->schemeUri;
        }

        return $array;
    }
}
