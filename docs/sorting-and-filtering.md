# Sorting and Filtering Examples

This document provides comprehensive examples of using the sorting and filtering functionality in the DataCite PHP SDK.

## Basic Setup

```php
<?php

require_once 'vendor/autoload.php';

use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\SortDirection;
use VincentAuger\DataCiteSdk\Enums\SortOption;
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;

// Create the client (public API, no auth needed)
$client = new DataCite();
```

## Sorting Examples

### Sort by Name (Ascending)

```php
$request = (new ListDOIs)
    ->withSortAsc(SortOption::NAME);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?sort=name
```

### Sort by Created Date (Descending)

```php
$request = (new ListDOIs)
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?sort=-created
```

### Sort by Relevance (Default)

```php
$request = (new ListDOIs)
    ->withSortDesc(SortOption::RELEVANCE);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?sort=-relevance
```

### Sort with Explicit Direction

```php
$request = (new ListDOIs)
    ->withSort(SortOption::NAME, SortDirection::ASC);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?sort=name
```

## Filtering Examples

### Filter by Provider

```php
$request = (new ListDOIs)
    ->withProviderId('cern')
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?provider-id=cern&sort=-created
```

### Filter by Client

```php
$request = (new ListDOIs)
    ->withClientId('cern.zenodo')
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?client-id=cern.zenodo&sort=-created
```

### Filter with QueryBuilder

```php
$request = (new ListDOIs)
    ->withClientId('cern.zenodo')
    ->withQuery(
        (new QueryBuilder)
            ->whereEquals('publicationYear', '2023')
    )
    ->withSortDesc(SortOption::PUBLISHED);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?client-id=cern.zenodo&query=publicationYear:2023&sort=-published
```

## Complex Examples

### Multiple Filters and Sorting

```php
$request = (new ListDOIs)
    ->withQuery(
        (new QueryBuilder)
            ->whereContains('titles.title', 'climate')
    )
    ->withProviderId('cern')
    ->withCreated('2023')
    ->withHasPerson(true)
    ->withHasFundingReference(true)
    ->withSortDesc(SortOption::CREATED)
    ->withPageSize(25)
    ->withAffiliation()
    ->withPublisher();

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?query=titles.title:*climate* publicationYear:2023&provider-id=cern&created=2023&has-person=true&has-funding-reference=true&sort=-created&page[size]=25&include=affiliation,publisher
```

### Date Range Filtering

```php
$request = (new ListDOIs)
    ->withCreated('2023-01-01,2023-12-31')
    ->withRegistered('2023-06-01,')
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?created=2023-01-01,2023-12-31&registered=2023-06-01,&sort=-created
```

### Include Additional Information

```php
$request = (new ListDOIs)
    ->withAffiliation()    // Include affiliation information
    ->withPublisher()      // Include publisher information
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?include=affiliation,publisher&sort=-created
```

### Wildcard and Exact Match Examples

#### Wildcard Searches

```php
use VincentAuger\DataCiteSdk\Enums\QueryField;

$request = (new ListDOIs)
    ->withQuery(
        (new QueryBuilder)
            ->whereExists(QueryField::CREATORS_NAME_IDENTIFIER)
            ->whereStartsWith(QueryField::CREATORS_FAMILY_NAME, 'Mil')
    );

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?query=creators.nameIdentifiers.nameIdentifier:* creators.familyName:Mil*
```

#### Exact Match with Spaces

```php
use VincentAuger\DataCiteSdk\Enums\QueryField;

$request = (new ListDOIs)
    ->withQuery(
        (new QueryBuilder)
            ->whereExact(QueryField::CREATORS_AFFILIATION_NAME, 'Oklahoma State University')
    );

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?query=creators.affiliation.name:"Oklahoma State University"
```

#### Exact Title Match

```php
use VincentAuger\DataCiteSdk\Enums\QueryField;

$request = (new ListDOIs)
    ->withQuery(
        (new QueryBuilder)
            ->whereExact(QueryField::TITLES_TITLE, 'CrowdoMeter Tweets')
    );

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?query=titles.title:"CrowdoMeter Tweets"
```

## Available Sort Options

The following sort options are available via the `SortOption` enum:

- `relevance` - Sort by relevance (default, always descending)
- `name` - Sort by DOI name
- `created` - Sort by creation date
- `registered` - Sort by registration date
- `updated` - Sort by last updated date
- `published` - Sort by publication date

## Available Sort Directions

The following sort directions are available via the `SortDirection` enum:

- `asc` - Ascending order
- `desc` - Descending order

## Available Filter Methods

### Basic Filters
- `withProviderId(string|array $providerId)` - Filter by provider ID(s)
- `withClientId(string|array $clientId)` - Filter by client ID(s)
- `withConsortiumId(string|array $consortiumId)` - Filter by consortium ID(s)
- `withCreated(string $date)` - Filter by creation date (year or date range)
- `withRegistered(string $date)` - Filter by registration date (year or date range)
- `withPrefix(string|array $prefix)` - Filter by DOI prefix(es)
- `withSchemaVersion(string $schemaVersion)` - Filter by metadata schema version

### Boolean Filters
- `withHasPerson(bool $hasPerson)` - Filter for DOIs with person information
- `withHasAffiliation(bool $hasAffiliation)` - Filter for DOIs with affiliation information
- `withHasFundingReference(bool $hasFundingReference)` - Filter for DOIs with funding references
- `withHasRelatedIdentifier(bool $hasRelatedIdentifier)` - Filter for DOIs with related identifiers
- `withHasAbstract(bool $hasAbstract)` - Filter for DOIs with abstracts
- `withHasMetadata(bool $hasMetadata)` - Filter for DOIs with metadata

### Additional Information (Include Parameters)
- `withAffiliation()` - Include full affiliation information in response
- `withPublisher()` - Include full publisher information in response

### Query Builder
- `withQuery(QueryBuilder $queryBuilder)` - Use QueryBuilder for complex field searches

## Pagination

```php
$request = (new ListDOIs)
    ->withPageSize(25)
    ->withPage(2)
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
$results = $response->dto();

echo "Page {$results->meta->page} of {$results->meta->totalPages}\n";
echo "Total results: {$results->meta->total}\n";
```

**Generated Query String:**
```
?page[size]=25&page[number]=2&sort=-created
```

## Sampling

```php
use VincentAuger\DataCiteSdk\Enums\SampleGroup;

$request = (new ListDOIs)
    ->withSample(10)
    ->withSampleGroup(SampleGroup::CLIENT)
    ->withSortDesc(SortOption::RELEVANCE);

$response = $client->send($request);
$results = $response->dto();
```

**Generated Query String:**
```
?sample=10&sample-group=client&sort=-relevance
```

## Complete Example

Here's a complete example that demonstrates multiple features:

```php
<?php

require_once 'vendor/autoload.php';

use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\{QueryField, SortOption};
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;

// Create the client
$client = new DataCite();

// Build a complex request with advanced query features
$request = (new ListDOIs)
    ->withQuery(
        (new QueryBuilder)
            ->whereContains(QueryField::TITLES_TITLE, 'machine learning')
            ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
            ->whereExists(QueryField::FUNDING_REFERENCES_FUNDER_NAME)
    )
    ->withProviderId('cern')
    ->withHasPerson(true)
    ->withHasAffiliation(true)
    ->withCreated('2023-01-01,2023-12-31')
    ->withAffiliation()
    ->withPublisher()
    ->withPageSize(50)
    ->withSortDesc(SortOption::RELEVANCE);

// Send the request
$response = $client->send($request);

// Process results
$dois = $response->dto();

foreach ($dois->data as $doi) {
    echo "DOI: {$doi->id}\n";
    echo "Title: {$doi->attributes->titles[0]->title}\n";
    echo "Created: {$doi->attributes->created}\n";
    echo "---\n";
}

echo "Total results: {$dois->meta->total}\n";
echo "Page: {$dois->meta->page} of {$dois->meta->totalPages}\n";
```

## Query String Reference

### Sort Parameters
- `sort=name` - Sort by name ascending
- `sort=-name` - Sort by name descending
- `sort=-relevance` - Sort by relevance (always descending)

### Filter Parameters
- `provider-id=cern` - Filter by provider ID
- `client-id=cern.zenodo` - Filter by client ID
- `created=2023` - Filter by creation year
- `created=2023-01-01,2023-12-31` - Filter by date range
- `has-person=true` - Filter for DOIs with person information
- `has-orcid=false` - Filter for DOIs without ORCID
- `include=affiliation,publisher` - Include additional information
- `include=detail` - Include all available fields

### Pagination Parameters
- `page[size]=25` - Set page size
- `page[number]=2` - Set page number

### Query Builder Parameters
- `query=titles.title:*climate*` - Contains search
- `query=publicationYear:2023` - Exact match
- `query=titles.title:*climate* publicationYear:2023` - Multiple conditions (space-separated)

### Wildcard Searches
- `query=creators.nameIdentifiers.nameIdentifier:*` - Match any value (using `whereWildcard`)
- `query=creators.familyName:mil*` - Starts with "mil" (using `whereStartsWithWildcard`)
- `query=titles.title:*learn?ng*` - Single character wildcard (using `whereSingleCharacterWildcard`)

### Exact Match Searches
- `query=creators.affiliation.name:"Oklahoma State University"` - Exact match (using `whereExact`)
- `query=creators.affiliation.name:Oklahoma\ State\ University*` - Exact match with wildcard (using `whereWildcardExact`)

### Sampling
- `sample=10` - Return random sample of 10 DOIs

This example demonstrates how to combine multiple filters, sorting, and pagination to create powerful queries against the DataCite API.