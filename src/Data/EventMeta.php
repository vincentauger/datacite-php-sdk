<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

/**
 * Meta statistics for Event Data list responses.
 *
 * @see https://support.datacite.org/docs/eventdata-guide#statistics
 */
final readonly class EventMeta
{
    /**
     * @param  MetaItem[]  $sources
     * @param  MetaItem[]  $occurred
     * @param  MetaItem[]  $prefixes
     * @param  MetaItem[]  $citationTypes
     * @param  MetaItem[]  $relationTypes
     * @param  MetaItem[]  $registrants
     */
    public function __construct(
        public int $total,
        public int $totalPages,
        public int $page,
        public array $sources,
        public array $occurred,
        public array $prefixes,
        public array $citationTypes,
        public array $relationTypes,
        public array $registrants,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_numeric($data['total']));
        assert(is_numeric($data['total-pages']));
        assert(is_numeric($data['page']));

        /** @var array<array<string, mixed>> $sourcesData */
        $sourcesData = $data['sources'] ?? [];
        /** @var array<array<string, mixed>> $occurredData */
        $occurredData = $data['occurred'] ?? [];
        /** @var array<array<string, mixed>> $prefixesData */
        $prefixesData = $data['prefixes'] ?? [];
        /** @var array<array<string, mixed>> $citationTypesData */
        $citationTypesData = $data['citation-types'] ?? [];
        /** @var array<array<string, mixed>> $relationTypesData */
        $relationTypesData = $data['relation-types'] ?? [];
        /** @var array<array<string, mixed>> $registrantsData */
        $registrantsData = $data['registrants'] ?? [];

        return new self(
            total: (int) $data['total'],
            totalPages: (int) $data['total-pages'],
            page: (int) $data['page'],
            sources: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $sourcesData
            ),
            occurred: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $occurredData
            ),
            prefixes: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $prefixesData
            ),
            citationTypes: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $citationTypesData
            ),
            relationTypes: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $relationTypesData
            ),
            registrants: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $registrantsData
            ),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'total-pages' => $this->totalPages,
            'page' => $this->page,
            'sources' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->sources
            ),
            'occurred' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->occurred
            ),
            'prefixes' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->prefixes
            ),
            'citation-types' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->citationTypes
            ),
            'relation-types' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->relationTypes
            ),
            'registrants' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->registrants
            ),
        ];
    }
}
