# QueryBuilder Reference

The QueryBuilder provides a fluent interface for building complex search queries for the DataCite API. It supports boolean operators, wildcards, exact matches, and nested queries.

## Basic Usage

```php
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;

$query = QueryBuilder::new()
    ->whereEquals('publicationYear', '2023')
    ->whereContains('titles.title', 'climate');

$request = ListDOIs::new()->withQuery($query);
```

## Methods

### Basic Comparisons

#### `whereEquals(string $field, string $value)`
Exact match on a field.

```php
QueryBuilder::new()
    ->whereEquals('publicationYear', '2023')
    ->whereEquals('types.resourceType', 'Dataset')
```

#### `whereContains(string $field, string $value)`
Contains search (case-insensitive).

```php
QueryBuilder::new()
    ->whereContains('titles.title', 'climate')
    ->whereContains('descriptions.description', 'machine learning')
```

#### `whereNotEquals(string $field, string $value)`
Negation of exact match.

```php
QueryBuilder::new()
    ->whereNotEquals('types.resourceType', 'Software')
```

### Wildcard Searches

#### `whereStartsWith(string $field, string $value)`
Field starts with value.

```php
QueryBuilder::new()
    ->whereStartsWith('titles.title', 'Climate')
```

#### `whereEndsWith(string $field, string $value)`
Field ends with value.

```php
QueryBuilder::new()
    ->whereEndsWith('titles.title', 'Analysis')
```

### Boolean Logic

#### `whereAnd(callable $callback)`
Group conditions with AND logic.

```php
QueryBuilder::new()
    ->whereAnd(function ($builder) {
        $builder
            ->whereEquals('publicationYear', '2023')
            ->whereContains('titles.title', 'climate');
    })
```

#### `whereOr(callable $callback)`
Group conditions with OR logic.

```php
QueryBuilder::new()
    ->whereOr(function ($builder) {
        $builder
            ->whereContains('titles.title', 'climate')
            ->whereContains('titles.title', 'weather');
    })
```

### Complex Examples

#### Multiple Conditions
```php
$query = QueryBuilder::new()
    ->whereEquals('publicationYear', '2023')
    ->whereContains('titles.title', 'climate')
    ->whereEquals('types.resourceType', 'Dataset');
```

#### Nested Boolean Logic
```php
$query = QueryBuilder::new()
    ->whereEquals('client.id', 'datacite.datacite')
    ->whereAnd(function ($builder) {
        $builder
            ->whereContains('titles.title', 'climate')
            ->whereOr(function ($builder) {
                $builder
                    ->whereContains('descriptions.description', 'temperature')
                    ->whereContains('descriptions.description', 'precipitation');
            });
    });
```

#### Wildcard Searches
```php
$query = QueryBuilder::new()
    ->whereStartsWith('titles.title', 'Climate')
    ->whereEndsWith('titles.title', 'Analysis')
    ->whereContains('creators.name', 'Smith');
```

## Common Search Fields

### Metadata Fields
- `titles.title` - DOI titles
- `descriptions.description` - DOI descriptions  
- `creators.name` - Creator names
- `contributors.name` - Contributor names
- `publicationYear` - Publication year
- `types.resourceType` - Resource type (Dataset, Software, etc.)
- `types.resourceTypeGeneral` - General resource type
- `subjects.subject` - Subject keywords

### Identifier Fields
- `doi` - DOI identifier
- `client.id` - Client ID
- `provider.id` - Provider ID
- `identifiers.identifier` - Alternative identifiers

### Date Fields
- `created` - Creation date
- `updated` - Last update date
- `published` - Publication date

### Count Fields
- `view-count` - View count
- `download-count` - Download count
- `citation-count` - Citation count

## Search Operators

The QueryBuilder automatically handles these DataCite search operators:

| Method | Operator | Example |
|--------|----------|---------|
| `whereEquals` | `:` | `titles.title:climate` |
| `whereContains` | `:*` | `titles.title:*climate*` |
| `whereNotEquals` | `!:` | `types.resourceType!:Software` |
| `whereStartsWith` | `:*` | `titles.title:Climate*` |
| `whereEndsWith` | `:*` | `titles.title:*Analysis` |

## Integration with ListDOIs

```php
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;
use VincentAuger\DataCiteSdk\Enums\SortOption;

// Complex query with sorting and pagination
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
            ->whereEquals('publicationYear', '2023')
            ->whereContains('titles.title', 'climate')
            ->whereEquals('types.resourceType', 'Dataset')
    )
    ->withSortDesc(SortOption::CREATED)
    ->withPageSize(25)
    ->withAffiliation();

// Execute the request
$response = $client->send($request);
$dois = $response->dto();
```

## Filter Parameters

In addition to the QueryBuilder, ListDOIs supports direct filter parameters for common filtering needs:

### Provider and Client Filters

```php
// Filter by provider
$request = ListDOIs::new()
    ->withProviderId('cern');

// Filter by client (repository)
$request = ListDOIs::new()
    ->withClientId('cern.zenodo');

// Filter by consortium
$request = ListDOIs::new()
    ->withConsortiumId('dcan');
```

### Metadata Filters

```php
// Filter by resource type
$request = ListDOIs::new()
    ->withResourceTypeId('output-management-plan');

// Filter by DOI prefix
$request = ListDOIs::new()
    ->withPrefix('10.5061');

// Filter by registration year
$request = ListDOIs::new()
    ->withRegistered('2023');

// Filter by creation year
$request = ListDOIs::new()
    ->withCreated('2023');

// Filter by schema version
$request = ListDOIs::new()
    ->withSchemaVersion('4');
```

### Content Filters

```php
// DOIs with person information
$request = ListDOIs::new()
    ->withHasPerson(true);

// DOIs with affiliation information
$request = ListDOIs::new()
    ->withHasAffiliation(true);

// DOIs with funding references
$request = ListDOIs::new()
    ->withHasFundingReference(true);

// DOIs with related identifiers
$request = ListDOIs::new()
    ->withHasRelatedIdentifier(true);

// DOIs with abstracts
$request = ListDOIs::new()
    ->withHasAbstract(true);

// DOIs with metadata
$request = ListDOIs::new()
    ->withHasMetadata(true);
```

### Combining All Parameters

```php
$request = ListDOIs::new()
    ->withQuery(
        QueryBuilder::new()
            ->whereContains('titles.title', 'climate')
    )
    ->withProviderId('cern')
    ->withCreated('2023')
    ->withHasPerson(true)
    ->withSortDesc(SortOption::CREATED)
    ->withPageSize(25)
    ->withAffiliation()
    ->withPublisher();
```

## Tips

1. **Use specific fields** - Search in specific fields rather than all fields for better performance
2. **Combine with sorting** - Use QueryBuilder with sort options for relevant results
3. **Boolean grouping** - Use `whereAnd()` and `whereOr()` for complex logic
4. **Wildcards** - Use `whereContains()` for partial matches when exact matching is too restrictive
5. **Field validation** - All field names are validated against DataCite API specifications

## Generated Query Examples

```php
// This QueryBuilder:
QueryBuilder::new()
    ->whereEquals('publicationYear', '2023')
    ->whereAnd(function ($builder) {
        $builder
            ->whereContains('titles.title', 'climate')
            ->whereOr(function ($builder) {
                $builder
                    ->whereContains('descriptions.description', 'temperature')
                    ->whereContains('descriptions.description', 'precipitation');
            });
    })

// Generates this query string:
"publicationYear:2023 (titles.title:*climate* (descriptions.description:*temperature* OR descriptions.description:*precipitation*))"
```