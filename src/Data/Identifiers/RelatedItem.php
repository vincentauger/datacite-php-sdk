<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

use VincentAuger\DataCiteSdk\Data\Metadata\Title;

final readonly class RelatedItem
{
    /**
     * @param  Title[]  $titles
     */
    public function __construct(
        public array $titles,
        public string $relationType,
        public string $relatedItemType,
        public ?RelatedItemIdentifier $relatedItemIdentifier = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            titles: array_map(
                fn (array $item) => Title::fromArray($item),
                $data['titles']
            ),
            relationType: $data['relationType'],
            relatedItemType: $data['relatedItemType'],
            relatedItemIdentifier: isset($data['relatedItemIdentifier'])
                ? RelatedItemIdentifier::fromArray($data['relatedItemIdentifier'])
                : null,
        );
    }

    public function toArray(): array
    {
        $array = [
            'titles' => array_map(fn (Title $title) => $title->toArray(), $this->titles),
            'relationType' => $this->relationType,
            'relatedItemType' => $this->relatedItemType,
        ];

        if ($this->relatedItemIdentifier !== null) {
            $array['relatedItemIdentifier'] = $this->relatedItemIdentifier->toArray();
        }

        return $array;
    }
}
