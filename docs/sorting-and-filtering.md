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

// Create the client
$client = DataCite::public();
```

## Sorting Examples

### Sort by Name (Ascending)

```php
$request = ListDOIs::new()
    ->withSortAsc(SortOption::NAME);

$response = $client->send($request);
```

**Generated Query String:**
```
?sort=name
```

### Sort by Created Date (Descending)

```php
$request = ListDOIs::new()
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
```

**Generated Query String:**
```
?sort=-created
```

### Sort by Relevance (Always Descending)

```php
$request = ListDOIs::new()
    ->withSort(SortOption::RELEVANCE);

$response = $client->send($request);
```

**Generated Query String:**
```
?sort=-relevance
```

### Sort with Explicit Direction

```php
$request = ListDOIs::new()
    ->withSort(SortOption::TITLE, SortDirection::ASC);

$response = $client->send($request);
```

**Generated Query String:**
```
?sort=title
```

## Filtering Examples

### Filter by Provider

```php
$request = ListDOIs::new()
    ->withProviderId('cern')
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
```

**Generated Query String:**
```
?provider-id=cern&sort=-created
```

### Filter by Client

```php
$request = ListDOIs::new()
    ->withClientId('cern.zenodo')
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
```

**Generated Query String:**
```
?client-id=cern.zenodo&sort=-created
```

### Filter with QueryBuilder

```php
$request = ListDOIs::new()
    ->withClientId('cern.zenodo')
    ->withQuery(
        QueryBuilder::new()
            ->whereEquals('publicationYear', '2023')
    )
    ->withSortDesc(SortOption::PUBLISHED);

$response = $client->send($request);
```

**Generated Query String:**
```
?client-id=cern.zenodo&query=publicationYear:2023&sort=-published
```

## Complex Examples

### Multiple Filters and Sorting

```php
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
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
```

**Generated Query String:**
```
?query=titles.title:*climate* publicationYear:2023&provider-id=cern&created=2023&has-person=true&has-funding-reference=true&sort=-created&page[size]=25&include=affiliation,publisher
```

### Date Range Filtering

```php
$request = ListDOIs::new()
    ->withCreated('2023-01-01,2023-12-31')
    ->withRegistered('2023-06-01,')
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
```

**Generated Query String:**
```
?created=2023-01-01,2023-12-31&registered=2023-06-01,&sort=-created
```

### Include Additional Information

```php
$request = ListDOIs::new()
    ->withAffiliation()    // Include affiliation information
    ->withPublisher()      // Include publisher information
    ->withDetail()         // Include all available fields
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
```

**Generated Query String:**
```
?include=affiliation,publisher,detail&sort=-created
```

### Wildcard and Exact Match Examples

#### Wildcard Searches

```php
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
            ->whereWildcard('creators.nameIdentifiers.nameIdentifier', '*')
            ->whereStartsWithWildcard('creators.familyName', 'mil')
    );

$response = $client->send($request);
```

**Generated Query String:**
```
?query=creators.nameIdentifiers.nameIdentifier:* creators.familyName:mil*
```

#### Exact Match with Spaces

```php
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
            ->whereExact('creators.affiliation.name', 'Oklahoma State University')
    );

$response = $client->send($request);
```

**Generated Query String:**
```
?query=creators.affiliation.name:"Oklahoma State University"
```

#### Exact Title Match (DataCite API Example)

```php
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
            ->whereExact('titles.title', 'CrowdoMeter Tweets')
    );

$response = $client->send($request);
```

**Generated Query String:**
```
?query=titles.title:"CrowdoMeter Tweets"
```

This matches the DataCite API example: `curl "https://api.datacite.org/dois?query=titles.title:%22CrowdoMeter%20Tweets%22"`

#### Exact Match with Wildcard (Advanced)

```php
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
            ->whereWildcardExact('creators.affiliation.name', 'Oklahoma State University', '*')
    );

$response = $client->send($request);
```

**Generated Query String:**
```
?query=creators.affiliation.name:Oklahoma\ State\ University*
```

#### Single Character Wildcard

```php
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
            ->whereSingleCharacterWildcard('titles.title', 'learn?ng')
    );

$response = $client->send($request);
```

**Generated Query String:**
```
?query=titles.title:learn?ng
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
- `withProviderId(string $providerId)` - Filter by provider ID
- `withClientId(string $clientId)` - Filter by client ID
- `withCreated(string $date)` - Filter by creation date
- `withRegistered(string $date)` - Filter by registration date
- `withUpdated(string $date)` - Filter by update date

### Boolean Filters
- `withHasPerson(bool $hasPerson)` - Filter for DOIs with person information
- `withHasFundingReference(bool $hasFundingReference)` - Filter for DOIs with funding references
- `withHasFullText(bool $hasFullText)` - Filter for DOIs with full text
- `withHasOrcid(bool $hasOrcid)` - Filter for DOIs with ORCID information
- `withHasLicense(bool $hasLicense)` - Filter for DOIs with license information
- `withIsActive(bool $isActive)` - Filter for active/inactive DOIs

### Content Filters
- `withSchemaVersion(string $schemaVersion)` - Filter by schema version
- `withPrefix(string $prefix)` - Filter by DOI prefix
- `withSuffix(string $suffix)` - Filter by DOI suffix
- `withNumber(string $number)` - Filter by DOI number
- `withDoi(string $doi)` - Filter by specific DOI
- `withUrl(string $url)` - Filter by URL
- `withCreator(string $creator)` - Filter by creator name
- `withTitle(string $title)` - Filter by title
- `withDescription(string $description)` - Filter by description
- `withPublisher(string $publisher)` - Filter by publisher name

### Additional Information
- `withAffiliation()` - Include affiliation information
- `withPublisher()` - Include publisher information
- `withDetail()` - Include all available fields

### Query Builder
- `withQuery(QueryBuilder $queryBuilder)` - Use QueryBuilder for complex queries

## Pagination

```php
$request = ListDOIs::new()
    ->withPageSize(25)
    ->withPage(2)
    ->withSortDesc(SortOption::CREATED);

$response = $client->send($request);
```

**Generated Query String:**
```
?page[size]=25&page[number]=2&sort=-created
```

## Sampling

```php
$request = ListDOIs::new()
    ->withSample(10)
    ->withSort(SortOption::RELEVANCE);

$response = $client->send($request);
```

**Generated Query String:**
```
?sample=10&sort=-relevance
```

## Complete Example

Here's a complete example that demonstrates multiple features:

```php
<?php

require_once 'vendor/autoload.php';

use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\SortDirection;
use VincentAuger\DataCiteSdk\Enums\SortOption;
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;

// Create the client
$client = DataCite::public();

// Build a complex request with advanced query features
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
            ->whereContains('titles.title', 'machine learning')
            ->whereEquals('publicationYear', '2023')
            ->whereWildcardExact('creators.affiliation.name', 'Massachusetts Institute of Technology', '*')
    )
    ->withProviderId('cern')
    ->withHasOrcid(true)
    ->withHasLicense(true)
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
    echo "Title: " . $doi->attributes->titles[0]->title . "\n";
    echo "Created: " . $doi->attributes->created . "\n";
    echo "---\n";
}

echo "Total results: {$dois->meta->total}\n";
echo "Page: {$dois->meta->page}\n";
echo "Page size: {$dois->meta->pageSize}\n";
```

**Generated Query String:**
```
?query=titles.title:*machine learning* publicationYear:2023 creators.affiliation.name:Massachusetts\ Institute\ of\ Technology*&provider-id=cern&has-orcid=true&has-license=true&created=2023-01-01,2023-12-31&include=affiliation,publisher&page[size]=50&sort=-relevance
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