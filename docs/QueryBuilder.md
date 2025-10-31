# QueryBuilder Reference

The QueryBuilder provides a fluent interface for building complex search queries for the DataCite API. It supports boolean operators, wildcards, exact matches, and nested queries.

## Basic Usage

The QueryBuilder accepts either `QueryField` enum values or string field names, providing type safety and IDE autocomplete while maintaining flexibility.

```php
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Enums\QueryField;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;

// Using QueryField enum (recommended for type safety and autocomplete)
$query = (new QueryBuilder)
    ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
    ->whereContains(QueryField::TITLES_TITLE, 'climate');

// Or using string field names (for flexibility)
$query = (new QueryBuilder)
    ->whereEquals('publicationYear', '2023')
    ->whereContains('titles.title', 'climate');

$request = (new ListDOIs)->withQuery($query);
```

## Methods

All methods accept either a `QueryField` enum or a `string` for the field parameter.

### Basic Comparisons

#### `whereEquals(QueryField|string $field, string $value)`
Exact match on a field.

```php
use VincentAuger\DataCiteSdk\Enums\QueryField;

(new QueryBuilder)
    ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
    ->whereEquals(QueryField::TYPES_RESOURCE_TYPE, 'Dataset')
```

#### `whereContains(QueryField|string $field, string $value)`
Contains search (case-insensitive).

```php
(new QueryBuilder)
    ->whereContains(QueryField::TITLES_TITLE, 'climate')
    ->whereContains(QueryField::DESCRIPTIONS_DESCRIPTION, 'machine learning')
```

#### `whereNotEquals(QueryField|string $field, string $value)`
Negation of exact match.

```php
(new QueryBuilder)
    ->whereNotEquals(QueryField::TYPES_RESOURCE_TYPE, 'Software')
```

### Wildcard Searches

#### `whereStartsWith(QueryField|string $field, string $value)`
Field starts with value.

```php
(new QueryBuilder)
    ->whereStartsWith(QueryField::TITLES_TITLE, 'Climate')
```

#### `whereEndsWith(QueryField|string $field, string $value)`
Field ends with value.

```php
(new QueryBuilder)
    ->whereEndsWith(QueryField::TITLES_TITLE, 'Analysis')
```

#### `whereWildcard(QueryField|string $field, string $pattern)`
Use custom wildcard patterns (`*` for multiple characters, `?` for single character).

```php
(new QueryBuilder)
    ->whereWildcard(QueryField::CREATORS_FAMILY_NAME, 'Sm?th')  // Matches Smith, Smyth
    ->whereWildcard(QueryField::CREATORS_NAME_IDENTIFIER, '*')  // Any identifier exists
```

#### `whereExists(QueryField|string $field)`
Check if a field has any value.

```php
(new QueryBuilder)
    ->whereExists(QueryField::CREATORS_NAME_IDENTIFIER)  // Has name identifier
    ->whereExists(QueryField::FUNDING_REFERENCES_FUNDER_NAME)  // Has funding
```

#### `whereNotExists(QueryField|string $field)`
Check if a field is empty.

```php
(new QueryBuilder)
    ->whereNotExists(QueryField::CREATORS_AFFILIATION_NAME)  // No affiliation
```

#### `whereExact(QueryField|string $field, string $value)`
Exact match with quoted value (for precise matching).

```php
(new QueryBuilder)
    ->whereExact(QueryField::TITLES_TITLE, 'CrowdoMeter Tweets')
```

### Boolean Logic

#### `whereAnd(callable $callback)`
Group conditions with AND logic.

```php
(new QueryBuilder)
    ->whereAnd(function (QueryBuilder $builder) {
        $builder
            ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
            ->whereContains(QueryField::TITLES_TITLE, 'climate');
    })
```

#### `whereOr(callable $callback)`
Group conditions with OR logic.

```php
(new QueryBuilder)
    ->whereOr(function (QueryBuilder $builder) {
        $builder
            ->whereContains(QueryField::TITLES_TITLE, 'climate')
            ->whereContains(QueryField::TITLES_TITLE, 'weather');
    })
```

#### `whereIn(QueryField|string $field, array $values)`
Match any of the provided values (OR logic).

```php
(new QueryBuilder)
    ->whereIn(QueryField::PUBLICATION_YEAR, ['2022', '2023', '2024'])
    ->whereIn(QueryField::TYPES_RESOURCE_TYPE, ['Dataset', 'Software'])
```

#### `whereNotIn(QueryField|string $field, array $values)`
Exclude all provided values.

```php
(new QueryBuilder)
    ->whereNotIn(QueryField::TYPES_RESOURCE_TYPE, ['Software', 'Text'])
```

### Complex Examples

#### Multiple Conditions
```php
use VincentAuger\DataCiteSdk\Enums\QueryField;

$query = (new QueryBuilder)
    ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
    ->whereContains(QueryField::TITLES_TITLE, 'climate')
    ->whereEquals(QueryField::TYPES_RESOURCE_TYPE, 'Dataset');
```

#### Nested Boolean Logic
```php
$query = (new QueryBuilder)
    ->whereAnd(function (QueryBuilder $builder) {
        $builder
            ->whereContains(QueryField::TITLES_TITLE, 'climate')
            ->whereOr(function (QueryBuilder $builder) {
                $builder
                    ->whereContains(QueryField::DESCRIPTIONS_DESCRIPTION, 'temperature')
                    ->whereContains(QueryField::DESCRIPTIONS_DESCRIPTION, 'precipitation');
            });
    });
```

#### Wildcard Searches
```php
$query = (new QueryBuilder)
    ->whereStartsWith(QueryField::TITLES_TITLE, 'Climate')
    ->whereEndsWith(QueryField::TITLES_TITLE, 'Analysis')
    ->whereContains(QueryField::CREATORS_NAME, 'Smith');
```

#### Finding Records with Identifiers
```php
// Find all DOIs with ORCID identifiers
$query = (new QueryBuilder)
    ->whereEquals(QueryField::CREATORS_NAME_IDENTIFIER_SCHEME, 'ORCID')
    ->whereExists(QueryField::CREATORS_NAME_IDENTIFIER);

// Find DOIs with ROR affiliations
$query = (new QueryBuilder)
    ->whereEquals(QueryField::CREATORS_AFFILIATION_IDENTIFIER_SCHEME, 'ROR')
    ->whereExists(QueryField::CREATORS_AFFILIATION_IDENTIFIER);
```

#### Searching Related Content
```php
// Find DOIs that cite or reference other works
$query = (new QueryBuilder)
    ->whereIn(QueryField::RELATED_IDENTIFIERS_RELATION_TYPE, ['Cites', 'References'])
    ->whereExists(QueryField::RELATED_IDENTIFIERS_RELATED_IDENTIFIER);

// Find datasets with funding information
$query = (new QueryBuilder)
    ->whereEquals(QueryField::TYPES_RESOURCE_TYPE_GENERAL, 'Dataset')
    ->whereExists(QueryField::FUNDING_REFERENCES_FUNDER_NAME);
```

## QueryField Enum Reference

The `QueryField` enum provides type-safe field names with IDE autocomplete support. All DataCite REST API query fields are available.

### Common Fields

#### Core Metadata
- `QueryField::DOI` - DOI identifier
- `QueryField::PUBLICATION_YEAR` - Publication year
- `QueryField::LANGUAGE` - Language code
- `QueryField::VERSION` - Version string

#### Titles
- `QueryField::TITLES_TITLE` - Title text
- `QueryField::TITLES_TITLE_TYPE` - Title type (e.g., AlternativeTitle)
- `QueryField::TITLES_LANG` - Title language

#### Creators
- `QueryField::CREATORS_NAME` - Creator name
- `QueryField::CREATORS_GIVEN_NAME` - Given/first name
- `QueryField::CREATORS_FAMILY_NAME` - Family/last name
- `QueryField::CREATORS_NAME_TYPE` - Personal or Organizational
- `QueryField::CREATORS_NAME_IDENTIFIER` - ORCID, ISNI, etc.
- `QueryField::CREATORS_NAME_IDENTIFIER_SCHEME` - Identifier scheme
- `QueryField::CREATORS_AFFILIATION_NAME` - Institution/organization name
- `QueryField::CREATORS_AFFILIATION_IDENTIFIER` - ROR, GRID, etc.
- `QueryField::CREATORS_AFFILIATION_IDENTIFIER_SCHEME` - Affiliation identifier scheme

#### Contributors
- `QueryField::CONTRIBUTORS_NAME` - Contributor name
- `QueryField::CONTRIBUTORS_CONTRIBUTOR_TYPE` - ContactPerson, DataCurator, etc.
- `QueryField::CONTRIBUTORS_GIVEN_NAME` - Given/first name
- `QueryField::CONTRIBUTORS_FAMILY_NAME` - Family/last name
- `QueryField::CONTRIBUTORS_NAME_IDENTIFIER` - Identifier value
- `QueryField::CONTRIBUTORS_AFFILIATION_NAME` - Institution/organization

#### Publisher
- `QueryField::PUBLISHER` - Publisher name (simple)
- `QueryField::PUBLISHER_NAME` - Publisher name (nested)
- `QueryField::PUBLISHER_IDENTIFIER` - Publisher identifier (Schema 4.5+)
- `QueryField::PUBLISHER_IDENTIFIER_SCHEME` - Publisher identifier scheme

#### Types
- `QueryField::TYPES_RESOURCE_TYPE` - Specific resource type
- `QueryField::TYPES_RESOURCE_TYPE_GENERAL` - General category (Dataset, Software, etc.)

#### Descriptions
- `QueryField::DESCRIPTIONS_DESCRIPTION` - Description text
- `QueryField::DESCRIPTIONS_DESCRIPTION_TYPE` - Abstract, Methods, TechnicalInfo, etc.
- `QueryField::DESCRIPTIONS_LANG` - Description language

#### Subjects
- `QueryField::SUBJECTS_SUBJECT` - Subject/keyword text
- `QueryField::SUBJECTS_SUBJECT_SCHEME` - Subject scheme name
- `QueryField::SUBJECTS_CLASSIFICATION_CODE` - Classification code

#### Related Identifiers
- `QueryField::RELATED_IDENTIFIERS_RELATED_IDENTIFIER` - Related identifier value
- `QueryField::RELATED_IDENTIFIERS_RELATION_TYPE` - Cites, IsSupplementTo, etc.
- `QueryField::RELATED_IDENTIFIERS_RELATED_IDENTIFIER_TYPE` - DOI, URL, arXiv, etc.

#### Funding References
- `QueryField::FUNDING_REFERENCES_FUNDER_NAME` - Funder organization name
- `QueryField::FUNDING_REFERENCES_FUNDER_IDENTIFIER` - Funder identifier (ROR, Crossref Funder ID)
- `QueryField::FUNDING_REFERENCES_AWARD_NUMBER` - Grant/award number
- `QueryField::FUNDING_REFERENCES_AWARD_TITLE` - Grant/award title

#### Rights/Licenses
- `QueryField::RIGHTS_LIST_RIGHTS` - License/rights statement
- `QueryField::RIGHTS_LIST_RIGHTS_URI` - License URL
- `QueryField::RIGHTS_LIST_RIGHTS_IDENTIFIER` - License identifier (e.g., CC-BY-4.0)

#### Geo Locations
- `QueryField::GEO_LOCATIONS_GEO_LOCATION_PLACE` - Place name

#### Dates
- `QueryField::DATES_DATE` - Date value
- `QueryField::DATES_DATE_TYPE` - Accepted, Available, Collected, etc.

#### Alternate Identifiers
- `QueryField::ALTERNATE_IDENTIFIERS_ALTERNATE_IDENTIFIER` - Alternate identifier value
- `QueryField::IDENTIFIERS_IDENTIFIER` - Identifier value (legacy)
- `QueryField::IDENTIFIERS_IDENTIFIER_TYPE` - Identifier type

#### Related Items (Schema 4.4+)
- `QueryField::RELATED_ITEMS_RELATED_ITEM_TYPE` - JournalArticle, Book, etc.
- `QueryField::RELATED_ITEMS_RELATION_TYPE` - IsPublishedIn, etc.
- `QueryField::RELATED_ITEMS_TITLES_TITLE` - Related item title
- `QueryField::RELATED_ITEMS_CREATORS_NAME` - Related item creator

### Using QueryField Enum

```php
use VincentAuger\DataCiteSdk\Enums\QueryField;

// Type-safe with autocomplete
$query = (new QueryBuilder)
    ->whereEquals(QueryField::CREATORS_NAME_IDENTIFIER_SCHEME, 'ORCID')
    ->whereContains(QueryField::TITLES_TITLE, 'climate')
    ->whereExists(QueryField::FUNDING_REFERENCES_FUNDER_NAME);

// Get the field name as a string if needed
echo QueryField::TITLES_TITLE->value; // "titles.title"
```

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
use VincentAuger\DataCiteSdk\Enums\QueryField;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;
use VincentAuger\DataCiteSdk\Enums\SortOption;

// Complex query with sorting and pagination
$request = (new ListDOIs)
    ->withQuery(
        (new QueryBuilder)
            ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
            ->whereContains(QueryField::TITLES_TITLE, 'climate')
            ->whereEquals(QueryField::TYPES_RESOURCE_TYPE, 'Dataset')
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
use VincentAuger\DataCiteSdk\Enums\QueryField;

$request = (new ListDOIs)
    ->withQuery(
        (new QueryBuilder)
            ->whereContains(QueryField::TITLES_TITLE, 'climate')
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

1. **Use QueryField enum** - Get type safety and IDE autocomplete by using `QueryField` enum values instead of strings
2. **Use specific fields** - Search in specific fields rather than all fields for better performance
3. **Combine with sorting** - Use QueryBuilder with sort options for relevant results
4. **Boolean grouping** - Use `whereAnd()` and `whereOr()` for complex logic
5. **Wildcards** - Use `whereContains()` for partial matches when exact matching is too restrictive
6. **Field validation** - All QueryField enum values map to valid DataCite API field names
7. **Flexibility** - Both enum and string field names are supported for maximum flexibility

## Generated Query Examples

```php
use VincentAuger\DataCiteSdk\Enums\QueryField;

// This QueryBuilder:
(new QueryBuilder)
    ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
    ->whereAnd(function (QueryBuilder $builder) {
        $builder
            ->whereContains(QueryField::TITLES_TITLE, 'climate')
            ->whereOr(function (QueryBuilder $builder) {
                $builder
                    ->whereContains(QueryField::DESCRIPTIONS_DESCRIPTION, 'temperature')
                    ->whereContains(QueryField::DESCRIPTIONS_DESCRIPTION, 'precipitation');
            });
    })

// Generates this query string:
"publicationYear:2023 (titles.title:*climate* (descriptions.description:*temperature* OR descriptions.description:*precipitation*))"
```

## Raw Queries

For advanced use cases, you can add raw query strings:

```php
(new QueryBuilder)
    ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
    ->raw('titles.title:(climate OR weather)')
    ->build();
```