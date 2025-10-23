<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Relationships;

final readonly class RelationshipData
{
    /**
     * @param  RelationshipItem[]  $references
     * @param  RelationshipItem[]  $citations
     * @param  RelationshipItem[]  $parts
     * @param  RelationshipItem[]  $partOf
     * @param  RelationshipItem[]  $versions
     * @param  RelationshipItem[]  $versionOf
     */
    public function __construct(
        public RelationshipClient $client,
        public RelationshipProvider $provider,
        public RelationshipMedia $media,
        public array $references,
        public array $citations,
        public array $parts,
        public array $partOf,
        public array $versions,
        public array $versionOf,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            client: RelationshipClient::fromArray($data['client']['data']),
            provider: RelationshipProvider::fromArray($data['provider']['data']),
            media: RelationshipMedia::fromArray($data['media']['data']),
            references: array_map(
                fn (array $item) => RelationshipItem::fromArray($item),
                $data['references']['data']
            ),
            citations: array_map(
                fn (array $item) => RelationshipItem::fromArray($item),
                $data['citations']['data']
            ),
            parts: array_map(
                fn (array $item) => RelationshipItem::fromArray($item),
                $data['parts']['data']
            ),
            partOf: array_map(
                fn (array $item) => RelationshipItem::fromArray($item),
                $data['partOf']['data']
            ),
            versions: array_map(
                fn (array $item) => RelationshipItem::fromArray($item),
                $data['versions']['data']
            ),
            versionOf: array_map(
                fn (array $item) => RelationshipItem::fromArray($item),
                $data['versionOf']['data']
            ),
        );
    }
}
