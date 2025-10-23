<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class RelatedItemIdentifier
{
    public function __construct(
        public string $relatedItemIdentifier,
        public string $relatedItemIdentifierType,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            relatedItemIdentifier: $data['relatedItemIdentifier'],
            relatedItemIdentifierType: $data['relatedItemIdentifierType'],
        );
    }

    public function toArray(): array
    {
        return [
            'relatedItemIdentifier' => $this->relatedItemIdentifier,
            'relatedItemIdentifierType' => $this->relatedItemIdentifierType,
        ];
    }
}
