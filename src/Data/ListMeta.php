<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

final readonly class ListMeta
{
    /**
     * @param  MetaItem[]  $states
     * @param  MetaItem[]  $resourceTypes
     * @param  MetaItem[]  $created
     * @param  MetaItem[]  $published
     * @param  MetaItem[]  $registered
     * @param  MetaItem[]  $providers
     * @param  MetaItem[]  $clients
     * @param  MetaItem[]  $affiliations
     * @param  MetaItem[]  $prefixes
     * @param  MetaItem[]  $certificates
     * @param  MetaItem[]  $licenses
     * @param  MetaItem[]  $schemaVersions
     * @param  MetaItem[]  $linkChecksStatus
     * @param  MetaItem[]  $subjects
     * @param  MetaItem[]  $fieldsOfScience
     * @param  MetaItem[]  $citations
     * @param  MetaItem[]  $views
     * @param  MetaItem[]  $downloads
     */
    public function __construct(
        public int $total,
        public int $totalPages,
        public int $page,
        public array $states,
        public array $resourceTypes,
        public array $created,
        public array $published,
        public array $registered,
        public array $providers,
        public array $clients,
        public array $affiliations,
        public array $prefixes,
        public array $certificates,
        public array $licenses,
        public array $schemaVersions,
        public array $linkChecksStatus,
        public array $subjects,
        public array $fieldsOfScience,
        public array $citations,
        public array $views,
        public array $downloads,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_numeric($data['total']));
        assert(is_numeric($data['totalPages']));
        assert(is_numeric($data['page']));
        assert(is_array($data['states']));
        assert(is_array($data['resourceTypes']));
        assert(is_array($data['created']));
        assert(is_array($data['published']));
        assert(is_array($data['registered']));
        assert(is_array($data['providers']));
        assert(is_array($data['clients']));
        assert(is_array($data['affiliations']));
        assert(is_array($data['prefixes']));
        assert(is_array($data['certificates']));
        assert(is_array($data['licenses']));
        assert(is_array($data['schemaVersions']));
        assert(is_array($data['linkChecksStatus']));
        assert(is_array($data['subjects']));
        assert(is_array($data['fieldsOfScience']));
        assert(is_array($data['citations']));
        assert(is_array($data['views']));
        assert(is_array($data['downloads']));

        /** @var array<array<string, mixed>> $statesData */
        $statesData = $data['states'];
        /** @var array<array<string, mixed>> $resourceTypesData */
        $resourceTypesData = $data['resourceTypes'];
        /** @var array<array<string, mixed>> $createdData */
        $createdData = $data['created'];
        /** @var array<array<string, mixed>> $publishedData */
        $publishedData = $data['published'];
        /** @var array<array<string, mixed>> $registeredData */
        $registeredData = $data['registered'];
        /** @var array<array<string, mixed>> $providersData */
        $providersData = $data['providers'];
        /** @var array<array<string, mixed>> $clientsData */
        $clientsData = $data['clients'];
        /** @var array<array<string, mixed>> $affiliationsData */
        $affiliationsData = $data['affiliations'];
        /** @var array<array<string, mixed>> $prefixesData */
        $prefixesData = $data['prefixes'];
        /** @var array<array<string, mixed>> $certificatesData */
        $certificatesData = $data['certificates'];
        /** @var array<array<string, mixed>> $licensesData */
        $licensesData = $data['licenses'];
        /** @var array<array<string, mixed>> $schemaVersionsData */
        $schemaVersionsData = $data['schemaVersions'];
        /** @var array<array<string, mixed>> $linkChecksStatusData */
        $linkChecksStatusData = $data['linkChecksStatus'];
        /** @var array<array<string, mixed>> $subjectsData */
        $subjectsData = $data['subjects'];
        /** @var array<array<string, mixed>> $fieldsOfScienceData */
        $fieldsOfScienceData = $data['fieldsOfScience'];
        /** @var array<array<string, mixed>> $citationsData */
        $citationsData = $data['citations'];
        /** @var array<array<string, mixed>> $viewsData */
        $viewsData = $data['views'];
        /** @var array<array<string, mixed>> $downloadsData */
        $downloadsData = $data['downloads'];

        return new self(
            total: (int) $data['total'],
            totalPages: (int) $data['totalPages'],
            page: (int) $data['page'],
            states: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $statesData
            ),
            resourceTypes: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $resourceTypesData
            ),
            created: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $createdData
            ),
            published: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $publishedData
            ),
            registered: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $registeredData
            ),
            providers: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $providersData
            ),
            clients: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $clientsData
            ),
            affiliations: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $affiliationsData
            ),
            prefixes: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $prefixesData
            ),
            certificates: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $certificatesData
            ),
            licenses: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $licensesData
            ),
            schemaVersions: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $schemaVersionsData
            ),
            linkChecksStatus: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $linkChecksStatusData
            ),
            subjects: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $subjectsData
            ),
            fieldsOfScience: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $fieldsOfScienceData
            ),
            citations: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $citationsData
            ),
            views: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $viewsData
            ),
            downloads: array_map(
                fn (array $item): MetaItem => MetaItem::fromArray($item),
                $downloadsData
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
            'totalPages' => $this->totalPages,
            'page' => $this->page,
            'states' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->states
            ),
            'resourceTypes' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->resourceTypes
            ),
            'created' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->created
            ),
            'published' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->published
            ),
            'registered' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->registered
            ),
            'providers' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->providers
            ),
            'clients' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->clients
            ),
            'affiliations' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->affiliations
            ),
            'prefixes' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->prefixes
            ),
            'certificates' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->certificates
            ),
            'licenses' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->licenses
            ),
            'schemaVersions' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->schemaVersions
            ),
            'linkChecksStatus' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->linkChecksStatus
            ),
            'subjects' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->subjects
            ),
            'fieldsOfScience' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->fieldsOfScience
            ),
            'citations' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->citations
            ),
            'views' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->views
            ),
            'downloads' => array_map(
                fn (MetaItem $item): array => $item->toArray(),
                $this->downloads
            ),
        ];
    }
}
