<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\Events;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\DataCiteSdk\Data\ListEventData;
use VincentAuger\DataCiteSdk\Enums\EventSortOption;
use VincentAuger\DataCiteSdk\Enums\SortDirection;
use VincentAuger\DataCiteSdk\Traits\Requests\HasPaginationParams;

/**
 * List DataCite events with optional filtering and sorting.
 *
 * @see https://support.datacite.org/docs/eventdata-guide
 */
final class ListEvents extends Request
{
    use CreatesDtoFromResponse;
    use HasPaginationParams;

    protected Method $method = Method::GET;

    /**
     * Query for any event information.
     */
    public function withQuery(string $query): self
    {
        $this->query()->add('query', $query);

        return $this;
    }

    /**
     * Filter by the identifier for the event subject expressed as URL.
     */
    public function withSubjId(string $subjId): self
    {
        $this->query()->add('subj-id', $subjId);

        return $this;
    }

    /**
     * Filter by the identifier for the event object expressed as URL.
     */
    public function withObjId(string $objId): self
    {
        $this->query()->add('obj-id', $objId);

        return $this;
    }

    /**
     * Filter by the subj-id or obj-id of the event expressed as DOI.
     */
    public function withDoi(string $doi): self
    {
        $this->query()->add('doi', $doi);

        return $this;
    }

    /**
     * Filter by the DOI prefix of the subj-id or obj-id of the event.
     *
     * @param  string|string[]  $prefix  Single prefix or array of prefixes
     */
    public function withPrefix(string|array $prefix): self
    {
        $value = is_array($prefix) ? implode(',', $prefix) : $prefix;
        $this->query()->add('prefix', $value);

        return $this;
    }

    /**
     * Filter by the subj-id or obj-id of the event expressed as an ORCID iD.
     */
    public function withOrcid(string $orcid): self
    {
        $this->query()->add('orcid', $orcid);

        return $this;
    }

    /**
     * Filter by the year and month in which the event occurred.
     *
     * @param  string  $yearMonth  Format: YYYY-MM
     */
    public function withYearMonth(string $yearMonth): self
    {
        $this->query()->add('year-month', $yearMonth);

        return $this;
    }

    /**
     * Filter by the source of the event.
     *
     * @param  string|string[]  $sourceId  Single source ID or array of source IDs
     */
    public function withSourceId(string|array $sourceId): self
    {
        $value = is_array($sourceId) ? implode(',', $sourceId) : $sourceId;
        $this->query()->add('source-id', $value);

        return $this;
    }

    /**
     * Filter by the relation type of the event.
     *
     * @param  string|string[]  $relationTypeId  Single relation type ID or array of relation type IDs
     */
    public function withRelationTypeId(string|array $relationTypeId): self
    {
        $value = is_array($relationTypeId) ? implode(',', $relationTypeId) : $relationTypeId;
        $this->query()->add('relation-type-id', $value);

        return $this;
    }

    /**
     * Filter by subtype.
     */
    public function withSubtype(string $subtype): self
    {
        $this->query()->add('subtype', $subtype);

        return $this;
    }

    /**
     * Filter by citation type.
     */
    public function withCitationType(string $citationType): self
    {
        $this->query()->add('citation-type', $citationType);

        return $this;
    }

    /**
     * Filter by registrant ID.
     */
    public function withRegistrantId(string $registrantId): self
    {
        $this->query()->add('registrant-id', $registrantId);

        return $this;
    }

    /**
     * Filter by publication year.
     *
     * @param  int|string  $year  Publication year
     */
    public function withPublicationYear(int|string $year): self
    {
        $this->query()->add('publication-year', (string) $year);

        return $this;
    }

    /**
     * Set sort order for events.
     */
    public function withSort(EventSortOption $sort, ?SortDirection $direction = null): self
    {
        $sortValue = $sort->value;

        // Apply direction if specified (relevance cannot be reversed)
        if ($direction === SortDirection::DESC && $sort !== EventSortOption::RELEVANCE) {
            $sortValue = "-{$sortValue}";
        }

        $this->query()->add('sort', $sortValue);

        return $this;
    }

    /**
     * Set sort order in ascending direction.
     */
    public function withSortAsc(EventSortOption $sort): self
    {
        return $this->withSort($sort, SortDirection::ASC);
    }

    /**
     * Set sort order in descending direction.
     */
    public function withSortDesc(EventSortOption $sort): self
    {
        return $this->withSort($sort, SortDirection::DESC);
    }

    public function resolveEndpoint(): string
    {
        return '/events';
    }

    public function createDtoFromResponse(Response $response): ListEventData
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return ListEventData::fromArray($data);
    }
}
