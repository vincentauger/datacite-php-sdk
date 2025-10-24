<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Http\Request;
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Traits\Requests\HasAdditionalInformation;
use VincentAuger\DataCiteSdk\Traits\Requests\HasPaginationParams;
use VincentAuger\DataCiteSdk\Traits\Requests\HasSamplingParams;
use VincentAuger\DataCiteSdk\Traits\Requests\HasSortParams;

final class ListDOIs extends Request
{
    use HasAdditionalInformation;
    use HasPaginationParams;
    use HasSamplingParams;
    use HasSortParams;

    private ?QueryBuilder $queryBuilder = null;

    public function withQuery(QueryBuilder $queryBuilder): self
    {
        $clone = clone $this;
        $clone->queryBuilder = $queryBuilder;

        return $clone;
    }

    // Filter parameter methods
    public function withProviderId(string $providerId): self
    {
        $this->query()->add('provider-id', $providerId);

        return $this;
    }

    public function withClientId(string $clientId): self
    {
        $this->query()->add('client-id', $clientId);

        return $this;
    }

    public function withConsortiumId(string $consortiumId): self
    {
        $this->query()->add('consortium-id', $consortiumId);

        return $this;
    }

    public function withResourceTypeId(string $resourceTypeId): self
    {
        $this->query()->add('resource-type-id', $resourceTypeId);

        return $this;
    }

    public function withPrefix(string $prefix): self
    {
        $this->query()->add('prefix', $prefix);

        return $this;
    }

    public function withRegistered(string $year): self
    {
        $this->query()->add('registered', $year);

        return $this;
    }

    public function withCreated(string $year): self
    {
        $this->query()->add('created', $year);

        return $this;
    }

    public function withSchemaVersion(string $version): self
    {
        $this->query()->add('schema-version', $version);

        return $this;
    }

    public function withHasPerson(bool $has = true): self
    {
        $this->query()->add('has-person', $has ? 'true' : 'false');

        return $this;
    }

    public function withHasAffiliation(bool $has = true): self
    {
        $this->query()->add('has-affiliation', $has ? 'true' : 'false');

        return $this;
    }

    public function withHasFundingReference(bool $has = true): self
    {
        $this->query()->add('has-funding-reference', $has ? 'true' : 'false');

        return $this;
    }

    public function withHasRelatedIdentifier(bool $has = true): self
    {
        $this->query()->add('has-related-identifier', $has ? 'true' : 'false');

        return $this;
    }

    public function withHasAbstract(bool $has = true): self
    {
        $this->query()->add('has-abstract', $has ? 'true' : 'false');

        return $this;
    }

    public function withHasMetadata(bool $has = true): self
    {
        $this->query()->add('has-metadata', $has ? 'true' : 'false');

        return $this;
    }

    // List-specific field methods
    public function withDetail(bool $flag = true): self
    {
        $this->query()->add('detail', $flag ? 'true' : 'false');

        return $this;
    }

    /** @param string[] $fields */
    public function withFields(array $fields): self
    {
        $this->query()->add('fields[dois]', implode(',', $fields));

        return $this;
    }

    public function resolveEndpoint(): string
    {
        return '/dois';
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->queryBuilder instanceof \VincentAuger\DataCiteSdk\Query\QueryBuilder) {
            $queryString = $this->queryBuilder->build();
            if ($queryString !== '') {
                $query['query'] = $queryString;
            }
        }

        return $query;
    }
}
