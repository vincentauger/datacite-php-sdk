<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\DataCiteSdk\Data\ListDOIData;
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Traits\Requests\HasAdditionalInformation;
use VincentAuger\DataCiteSdk\Traits\Requests\HasPaginationParams;
use VincentAuger\DataCiteSdk\Traits\Requests\HasSamplingParams;
use VincentAuger\DataCiteSdk\Traits\Requests\HasSortParams;

final class ListDOIs extends Request
{
    use CreatesDtoFromResponse;
    use HasAdditionalInformation;
    use HasPaginationParams;
    use HasSamplingParams;
    use HasSortParams;

    protected Method $method = Method::GET;

    private ?QueryBuilder $queryBuilder = null;

    public function withQuery(QueryBuilder $queryBuilder): self
    {
        $clone = clone $this;
        $clone->queryBuilder = $queryBuilder;

        return $clone;
    }

    // Filter parameter methods
    /**
     * Filter by a specific DataCite provider (Direct Member or Consortium Organization).
     *
     * @param  string|string[]  $providerId  Single provider ID or array of provider IDs
     */
    public function withProviderId(string|array $providerId): self
    {
        $value = is_array($providerId) ? implode(',', $providerId) : $providerId;
        $this->query()->add('provider-id', $value);

        return $this;
    }

    /**
     * Filter by a specific DataCite client (repository).
     *
     * @param  string|string[]  $clientId  Single client ID or array of client IDs
     */
    public function withClientId(string|array $clientId): self
    {
        $value = is_array($clientId) ? implode(',', $clientId) : $clientId;
        $this->query()->add('client-id', $value);

        return $this;
    }

    /**
     * Filter by a specific DataCite consortium.
     *
     * @param  string|string[]  $consortiumId  Single consortium ID or array of consortium IDs
     */
    public function withConsortiumId(string|array $consortiumId): self
    {
        $value = is_array($consortiumId) ? implode(',', $consortiumId) : $consortiumId;
        $this->query()->add('consortium-id', $value);

        return $this;
    }

    /**
     * Filter by the resourceTypeGeneral.
     *
     * @param  string|string[]  $resourceTypeId  Single resource type ID or array of resource type IDs
     */
    public function withResourceTypeId(string|array $resourceTypeId): self
    {
        $value = is_array($resourceTypeId) ? implode(',', $resourceTypeId) : $resourceTypeId;
        $this->query()->add('resource-type-id', $value);

        return $this;
    }

    /**
     * Filter by a specific prefix.
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
     * Filter by the DOI date registered (yyyy).
     *
     * @param  int|int[]|string|string[]  $year  Single year or array of years
     */
    public function withRegistered(int|array|string $year): self
    {
        $value = is_array($year) ? implode(',', $year) : (string) $year;
        $this->query()->add('registered', $value);

        return $this;
    }

    /**
     * Filter by the DOI date created (yyyy).
     *
     * @param  int|int[]|string|string[]  $year  Single year or array of years
     */
    public function withCreated(int|array|string $year): self
    {
        $value = is_array($year) ? implode(',', $year) : (string) $year;
        $this->query()->add('created', $value);

        return $this;
    }

    /**
     * Filter by the DOI date published (yyyy).
     *
     * @param  int|int[]|string|string[]  $year  Single year or array of years
     */
    public function withPublished(int|array|string $year): self
    {
        $value = is_array($year) ? implode(',', $year) : (string) $year;
        $this->query()->add('published', $value);

        return $this;
    }

    public function withSchemaVersion(string $version): self
    {
        $this->query()->add('schema-version', $version);

        return $this;
    }

    /**
     * Search creators.affiliation.affiliationIdentifier and
     * contributors.affiliation.affiliationIdentifier for a ROR ID.
     */
    public function withAffiliationId(string $affiliationId): self
    {
        $this->query()->add('affiliation-id', $affiliationId);

        return $this;
    }

    /**
     * Search fundingReferences.funderIdentifier for a Crossref Funder ID.
     */
    public function withFunderId(string $funderId): self
    {
        $this->query()->add('funder-id', $funderId);

        return $this;
    }

    /**
     * Search creators.nameIdentifiers.nameIdentifier for an ORCID iD.
     */
    public function withUserId(string $userId): self
    {
        $this->query()->add('user-id', $userId);

        return $this;
    }

    /**
     * Filter by the free text resourceType.
     *
     * @param  string|string[]  $resourceType  Single resource type or array of resource types
     */
    public function withResourceType(string|array $resourceType): self
    {
        $value = is_array($resourceType) ? implode(',', $resourceType) : $resourceType;
        $this->query()->add('resource-type', $value);

        return $this;
    }

    /**
     * Filter by the free text Subject.
     *
     * @param  string|string[]  $subject  Single subject or array of subjects
     */
    public function withSubject(string|array $subject): self
    {
        $value = is_array($subject) ? implode(',', $subject) : $subject;
        $this->query()->add('subject', $value);

        return $this;
    }

    /**
     * Filter by Field of Science and Technology (FOS) subjects.
     *
     * @param  string|string[]  $fieldOfScience  Single FOS or array of FOS subjects
     */
    public function withFieldOfScience(string|array $fieldOfScience): self
    {
        $value = is_array($fieldOfScience) ? implode(',', $fieldOfScience) : $fieldOfScience;
        $this->query()->add('field-of-science', $value);

        return $this;
    }

    /**
     * Filter by license/rights identifier.
     *
     * @param  string|string[]  $license  Single license or array of licenses
     */
    public function withLicense(string|array $license): self
    {
        $value = is_array($license) ? implode(',', $license) : $license;
        $this->query()->add('license', $value);

        return $this;
    }

    /**
     * Filter by client type (repository, periodical, igsnCatalog, raidRegistry).
     *
     * @param  string|string[]  $clientType  Single client type or array of client types
     */
    public function withClientType(string|array $clientType): self
    {
        $value = is_array($clientType) ? implode(',', $clientType) : $clientType;
        $this->query()->add('client-type', $value);

        return $this;
    }

    /**
     * Filter by certificate type.
     *
     * @param  string|string[]  $certificate  Single certificate or array of certificates
     */
    public function withCertificate(string|array $certificate): self
    {
        $value = is_array($certificate) ? implode(',', $certificate) : $certificate;
        $this->query()->add('certificate', $value);

        return $this;
    }

    /**
     * Filter by the DOI state (draft, registered, findable).
     * Authentication is required to retrieve registered DOIs and draft records.
     *
     * @param  string|string[]  $state  Single state or array of states
     */
    public function withState(string|array $state): self
    {
        $value = is_array($state) ? implode(',', $state) : $state;
        $this->query()->add('state', $value);

        return $this;
    }

    /**
     * Filter by the status of the landing page link check.
     */
    public function withLinkCheckStatus(string $status): self
    {
        $this->query()->add('link-check-status', $status);

        return $this;
    }

    /**
     * Filter by the system used to create the DOI (mds, api, fabrica, form, fabricaez).
     */
    public function withSource(string $source): self
    {
        $this->query()->add('source', $source);

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

    /**
     * Return DOIs where either creators.nameIdentifiers.nameIdentifierScheme
     * or contributors.nameIdentifiers.nameIdentifierScheme has at least one "ROR" value.
     */
    public function withHasOrganization(bool $has = true): self
    {
        $this->query()->add('has-organization', $has ? 'true' : 'false');

        return $this;
    }

    /**
     * Return DOIs where fundingReferences.funderIdentifierType
     * has at least one "Crossref Funder ID" value.
     */
    public function withHasFunder(bool $has = true): self
    {
        $this->query()->add('has-funder', $has ? 'true' : 'false');

        return $this;
    }

    /**
     * Search the citationCount field for integer values greater than or equal to the inputted value.
     */
    public function withHasCitations(int $count): self
    {
        $this->query()->add('has-citations', (string) $count);

        return $this;
    }

    /**
     * Search the referenceCount field for integer values greater than or equal to the inputted value.
     */
    public function withHasReferences(int $count): self
    {
        $this->query()->add('has-references', (string) $count);

        return $this;
    }

    /**
     * Search the partCount field for integer values greater than or equal to the inputted value.
     */
    public function withHasParts(int $count): self
    {
        $this->query()->add('has-parts', (string) $count);

        return $this;
    }

    /**
     * Search the partOfCount field for integer values greater than or equal to the inputted value.
     */
    public function withHasPartOf(int $count): self
    {
        $this->query()->add('has-part-of', (string) $count);

        return $this;
    }

    /**
     * Search the versionCount field for integer values greater than or equal to the inputted value.
     */
    public function withHasVersions(int $count): self
    {
        $this->query()->add('has-versions', (string) $count);

        return $this;
    }

    /**
     * Search the versionOfCount field for integer values greater than or equal to the inputted value.
     */
    public function withHasVersionOf(int $count): self
    {
        $this->query()->add('has-version-of', (string) $count);

        return $this;
    }

    /**
     * Search the viewCount field for integer values greater than or equal to the inputted value.
     */
    public function withHasViews(int $count): self
    {
        $this->query()->add('has-views', (string) $count);

        return $this;
    }

    /**
     * Search the downloadCount field for integer values greater than or equal to the inputted value.
     */
    public function withHasDownloads(int $count): self
    {
        $this->query()->add('has-downloads', (string) $count);

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

    /**
     * Include related resources in the response (client, media).
     *
     * @param  string|string[]  $include  Single resource type or array of resource types
     */
    public function withInclude(string|array $include): self
    {
        $value = is_array($include) ? implode(',', $include) : $include;
        $this->query()->add('include', $value);

        return $this;
    }

    /**
     * Exclude facets from the response to improve performance.
     */
    public function withDisableFacets(bool $flag = true): self
    {
        $this->query()->add('disable-facets', $flag ? 'true' : 'false');

        return $this;
    }

    /**
     * Set the sample size for random sampling (1 to 1000).
     * Used in combination with withRandom() from HasSamplingParams trait.
     */
    public function withSampleSize(int $size): self
    {
        if ($size < 1 || $size > 1000) {
            throw new \InvalidArgumentException('Sample size must be between 1 and 1000');
        }

        $this->query()->add('sample-size', (string) $size);

        return $this;
    }

    public function resolveEndpoint(): string
    {
        return '/dois';
    }

    public function createDtoFromResponse(Response $response): ListDOIData
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return ListDOIData::fromArray($data);
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
