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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_array($data['client']));
        assert(is_array($data['provider']));
        assert(is_array($data['media']));
        assert(is_array($data['references']));
        assert(is_array($data['citations']));
        assert(is_array($data['parts']));
        assert(is_array($data['partOf']));
        assert(is_array($data['versions']));
        assert(is_array($data['versionOf']));

        assert(is_array($data['client']['data']));
        assert(is_array($data['provider']['data']));
        assert(is_array($data['media']['data']));
        assert(is_array($data['references']['data']));
        assert(is_array($data['citations']['data']));
        assert(is_array($data['parts']['data']));
        assert(is_array($data['partOf']['data']));
        assert(is_array($data['versions']['data']));
        assert(is_array($data['versionOf']['data']));

        /** @var array<string, mixed> $clientData */
        $clientData = $data['client']['data'];
        /** @var array<string, mixed> $providerData */
        $providerData = $data['provider']['data'];
        /** @var array<string, mixed> $mediaData */
        $mediaData = $data['media']['data'];
        /** @var array<array<string, mixed>> $referencesData */
        $referencesData = $data['references']['data'];
        /** @var array<array<string, mixed>> $citationsData */
        $citationsData = $data['citations']['data'];
        /** @var array<array<string, mixed>> $partsData */
        $partsData = $data['parts']['data'];
        /** @var array<array<string, mixed>> $partOfData */
        $partOfData = $data['partOf']['data'];
        /** @var array<array<string, mixed>> $versionsData */
        $versionsData = $data['versions']['data'];
        /** @var array<array<string, mixed>> $versionOfData */
        $versionOfData = $data['versionOf']['data'];

        return new self(
            client: RelationshipClient::fromArray($clientData),
            provider: RelationshipProvider::fromArray($providerData),
            media: RelationshipMedia::fromArray($mediaData),
            references: array_map(
                fn (array $item): \VincentAuger\DataCiteSdk\Data\Relationships\RelationshipItem => RelationshipItem::fromArray($item),
                $referencesData
            ),
            citations: array_map(
                fn (array $item): \VincentAuger\DataCiteSdk\Data\Relationships\RelationshipItem => RelationshipItem::fromArray($item),
                $citationsData
            ),
            parts: array_map(
                fn (array $item): \VincentAuger\DataCiteSdk\Data\Relationships\RelationshipItem => RelationshipItem::fromArray($item),
                $partsData
            ),
            partOf: array_map(
                fn (array $item): \VincentAuger\DataCiteSdk\Data\Relationships\RelationshipItem => RelationshipItem::fromArray($item),
                $partOfData
            ),
            versions: array_map(
                fn (array $item): \VincentAuger\DataCiteSdk\Data\Relationships\RelationshipItem => RelationshipItem::fromArray($item),
                $versionsData
            ),
            versionOf: array_map(
                fn (array $item): \VincentAuger\DataCiteSdk\Data\Relationships\RelationshipItem => RelationshipItem::fromArray($item),
                $versionOfData
            ),
        );
    }
}
