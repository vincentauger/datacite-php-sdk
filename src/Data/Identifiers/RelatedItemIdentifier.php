<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class RelatedItemIdentifier
{
    public function __construct(
        public string $relatedItemIdentifier,
        public string $relatedItemIdentifierType,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['relatedItemIdentifier']));
        assert(is_string($data['relatedItemIdentifierType']));

        return new self(
            relatedItemIdentifier: $data['relatedItemIdentifier'],
            relatedItemIdentifierType: $data['relatedItemIdentifierType'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'relatedItemIdentifier' => $this->relatedItemIdentifier,
            'relatedItemIdentifierType' => $this->relatedItemIdentifierType,
        ];
    }
}
