<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class RightsList
{
    public function __construct(
        public string $rights,
        public ?string $rightsUri = null,
        public ?string $rightsIdentifier = null,
        public ?string $rightsIdentifierScheme = null,
        public ?string $schemeUri = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            rights: $data['rights'],
            rightsUri: $data['rightsUri'] ?? null,
            rightsIdentifier: $data['rightsIdentifier'] ?? null,
            rightsIdentifierScheme: $data['rightsIdentifierScheme'] ?? null,
            schemeUri: $data['schemeUri'] ?? null,
        );
    }

    public function toArray(): array
    {
        $array = ['rights' => $this->rights];

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
