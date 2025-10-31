# DataCite PHP SDK (Unofficial)

A modern PHP SDK for the [DataCite REST API](https://support.datacite.org/docs/api), built for maintainability and clarity using [Saloon](https://docs.saloon.dev) for HTTP integration.

## Features

- ✅ **Modern PHP 8.4+** - Typed properties, readonly classes, enums, and constructor property promotion
- ✅ **Full DOI Management** - Create, read, update, delete, and search DOI records
- ✅ **DataCite Events** - Query and retrieve usage events for DOIs
- ✅ **Advanced Query Builder** - Fluent interface for complex searches with boolean logic
- ✅ **Typed DTOs** - Fully typed data transfer objects for all API responses
- ✅ **Built on Saloon** - Powerful HTTP client with mocking and testing support
- ✅ **Framework Agnostic** - Works with any PHP framework or standalone
- ✅ **Comprehensive Tests** - Full test coverage with Pest PHP

---

## Installation

```bash
composer require vincentauger/datacite-php-sdk
```

**Requirements:**
- PHP 8.4+
- Composer

---

## Quick Start

### Initialize the Client

#### Public API (Read-Only)

```php
use VincentAuger\DataCiteSdk\DataCite;

// No credentials needed for public read-only access
$datacite = new DataCite();
```

#### Member API (Full Access)

```php
use VincentAuger\DataCiteSdk\DataCite;

// Credentials required for create/update/delete operations
$datacite = new DataCite(
    username: 'your-repository-id',
    password: 'your-repository-password',
    mailto: 'your-email@example.com'  // Optional but recommended
);
```

---

## Usage Examples

### Get a Single DOI

```php
use VincentAuger\DataCiteSdk\Requests\DOIs\GetDOI;

$request = new GetDOI('10.5438/4k3m-nyvg');
$response = $datacite->send($request);
$doi = $response->dto();

// Access via fully typed DTO
echo $doi->data->attributes->titles[0]->title;
echo $doi->data->attributes->creators[0]->name;
echo $doi->data->attributes->publicationYear;
```

### List DOIs

```php
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;
use VincentAuger\DataCiteSdk\Enums\SortOption;

$request = (new ListDOIs)
    ->withPageSize(25)
    ->withSortDesc(SortOption::CREATED);

$response = $datacite->send($request);
$results = $response->dto();

foreach ($results->data as $doi) {
    echo "{$doi->id}: {$doi->attributes->titles[0]->title}\n";
}

echo "Total: {$results->meta->total}\n";
```

### Search DOIs with Query Builder

```php
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Enums\QueryField;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;

$query = (new QueryBuilder)
    ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
    ->whereContains(QueryField::TITLES_TITLE, 'climate')
    ->whereExists(QueryField::FUNDING_REFERENCES_FUNDER_NAME);

$request = (new ListDOIs)->withQuery($query);
$response = $datacite->send($request);
$results = $response->dto();
```

### Create a DOI

```php
use VincentAuger\DataCiteSdk\Requests\DOIs\CreateDOI;
use VincentAuger\DataCiteSdk\Data\CreateDOIInput;
use VincentAuger\DataCiteSdk\Data\Metadata\{Creator, Title, ResourceType};
use VincentAuger\DataCiteSdk\Enums\{ResourceTypeGeneral, DOIEvent};

$input = new CreateDOIInput(
    doi: '10.5438/example-doi',
    url: 'https://example.com/dataset',
    titles: [new Title('My Dataset Title')],
    creators: [new Creator(name: 'Smith, John')],
    publisher: new PublisherData(name: 'Example Publisher'),
    publicationYear: 2025,
    types: new ResourceType(
        resourceTypeGeneral: ResourceTypeGeneral::DATASET,
        resourceType: 'Dataset'
    ),
    event: DOIEvent::PUBLISH  // Optional: publish, register, or hide
);

$request = new CreateDOI($input);
$response = $datacite->send($request);
$doi = $response->dto();
```

### Update a DOI

```php
use VincentAuger\DataCiteSdk\Requests\DOIs\UpdateDOI;
use VincentAuger\DataCiteSdk\Data\UpdateDOIInput;

$input = new UpdateDOIInput(
    doi: '10.5438/example-doi',
    titles: [new Title('Updated Title')],
    // ... other updated fields
);

$request = new UpdateDOI('10.5438/example-doi', $input);
$response = $datacite->send($request);
```

### Delete a DOI

```php
use VincentAuger\DataCiteSdk\Requests\DOIs\DeleteDOI;

// Only works for draft DOIs
$request = new DeleteDOI('10.5438/draft-doi');
$response = $datacite->send($request);
```

### Get DOI Activities

```php
use VincentAuger\DataCiteSdk\Requests\DOIs\GetDOIActivities;

$request = new GetDOIActivities('10.5438/4k3m-nyvg');
$response = $datacite->send($request);
$activities = $response->dto();

foreach ($activities->data as $activity) {
    echo "{$activity->attributes->action} at {$activity->attributes->createdAt}\n";
}
```

### List Events

```php
use VincentAuger\DataCiteSdk\Requests\Events\ListEvents;
use VincentAuger\DataCiteSdk\Enums\{EventSortOption, EventSource};

$request = (new ListEvents)
    ->withDoiId('10.5438/4k3m-nyvg')
    ->withSource(EventSource::CROSSREF)
    ->withYearMonth('2023-06')
    ->withSortDesc(EventSortOption::TOTAL)
    ->withPageSize(25);

$response = $datacite->send($request);
$events = $response->dto();

foreach ($events->data as $event) {
    echo "{$event->id}: {$event->attributes->total} occurrences\n";
}
```

### Get a Single Event

```php
use VincentAuger\DataCiteSdk\Requests\Events\GetEvent;

$request = new GetEvent('event-id-here');
$response = $datacite->send($request);
$event = $response->dto();
```

---

## Advanced Features

### Query Builder

Build complex search queries with a fluent interface. See [docs/QueryBuilder.md](docs/QueryBuilder.md) for full documentation.

```php
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Enums\QueryField;

$query = (new QueryBuilder)
    ->whereEquals(QueryField::PUBLICATION_YEAR, '2023')
    ->whereOr(function (QueryBuilder $builder) {
        $builder
            ->whereContains(QueryField::TITLES_TITLE, 'climate')
            ->whereContains(QueryField::TITLES_TITLE, 'weather');
    })
    ->whereExists(QueryField::CREATORS_NAME_IDENTIFIER);
```

**Available Methods:**
- `whereEquals()`, `whereNotEquals()` - Exact matching
- `whereContains()` - Case-insensitive contains search
- `whereStartsWith()`, `whereEndsWith()` - Wildcard prefix/suffix
- `whereExists()`, `whereNotExists()` - Field presence checks
- `whereIn()`, `whereNotIn()` - Multiple value matching
- `whereAnd()`, `whereOr()` - Boolean logic grouping
- `whereExact()` - Quoted exact match for phrases

### Sorting and Filtering

Apply sorting, filtering, and pagination to list requests. See [docs/sorting-and-filtering.md](docs/sorting-and-filtering.md) for examples.

```php
use VincentAuger\DataCiteSdk\Enums\SortOption;

$request = (new ListDOIs)
    ->withProviderId('cern')
    ->withClientId('cern.zenodo')
    ->withCreated('2023-01-01,2023-12-31')  // Date range
    ->withHasPerson(true)
    ->withHasFundingReference(true)
    ->withSortDesc(SortOption::CREATED)
    ->withPageSize(50)
    ->withPage(2)
    ->withAffiliation()  // Include additional data
    ->withPublisher();
```

**DOI Sort Options:**
- `RELEVANCE` - Search relevance (default)
- `NAME` - DOI name
- `CREATED` - Creation date
- `UPDATED` - Last updated
- `PUBLISHED` - Publication date
- `REGISTERED` - Registration date

**Event Sort Options:**
- `RELEVANCE` - Search relevance
- `OBJ_ID` - Object ID
- `TOTAL` - Total occurrences
- `CREATED` - Creation date
- `UPDATED` - Last updated

---

## Configuration

### Client Options

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `baseUrl` | `string` | `https://api.datacite.org` | DataCite API base URL |
| `username` | `string\|null` | `null` | Repository ID (required for member API) |
| `password` | `string\|null` | `null` | Repository password (required for member API) |
| `mailto` | `string\|null` | `null` | Email for User-Agent header (optional) |

### Authentication

The SDK supports two access levels:

1. **Public API** (default) - Read-only access to DOI metadata and events (no credentials needed)
2. **Member API** - Full access including create/update/delete (requires credentials)

```php
// Public API - read-only
$datacite = new DataCite();

// Member API - full access
$datacite = new DataCite(
    apiVersion: ApiVersion::MEMBER,
    username: 'your-repository-id',
    password: 'your-repository-password'
);
```

Endpoints that modify data (POST, PUT, DELETE) use the `RequiresMemberAuth` trait and will throw a `RuntimeException` if you attempt these operations without proper authentication.

---

## API Coverage

### System
- ✅ `GET /heartbeat` - Check API status

### DOIs
- ✅ `GET /dois` - List DOIs with advanced filtering
- ✅ `GET /dois/{id}` - Get a single DOI
- ✅ `POST /dois` - Create a new DOI (member only)
- ✅ `PUT /dois/{id}` - Update a DOI (member only)
- ✅ `DELETE /dois/{id}` - Delete a draft DOI (member only)
- ✅ `GET /dois/{id}/activities` - Get DOI activity log

### Events
- ✅ `GET /events` - List events with filtering
- ✅ `GET /events/{id}` - Get a single event

---

## Project Structure

```
src/
├── DataCite.php              # Main client
├── Requests/                 # API endpoint classes
│   ├── DOIs/                 # DOI operations
│   ├── Events/               # Event operations
│   └── GetHeartbeat.php      # System heartbeat
├── Data/                     # Response DTOs
│   ├── DOIData.php           # DOI response
│   ├── ListDOIData.php       # DOI list response
│   ├── EventData.php         # Event response
│   ├── ListEventData.php     # Event list response
│   └── Metadata/             # Metadata DTOs
├── Enums/                    # Type-safe enumerations
├── Query/                    # Query builder
└── Traits/                   # Shared functionality
```

---

## Testing

Run the full test suite:

```bash
composer test          # Run all tests (lint, unit, types, refactor)
composer test:unit     # Run Pest unit tests only
composer test:types    # Run PHPStan static analysis
composer lint          # Run Laravel Pint formatter
composer refactor      # Run Rector code improvements
```

---

## Development

### Code Quality

This project follows strict PHP standards:

- **PHP 8.4+** syntax only
- `declare(strict_types=1)` in every file
- All classes are `final` unless inheritance is required
- DTOs use `readonly` properties with constructor property promotion
- PSR-12 coding standards
- Level max PHPStan static analysis

### Quality Tools

```bash
composer test          # Run all checks
composer test:unit     # Pest unit tests
composer test:types    # PHPStan static analysis (level max)
composer lint          # Laravel Pint code formatting
composer refactor      # Rector automated refactoring
```

All quality checks must pass before committing.

---

## Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for:
- Development environment setup
- Coding standards and guidelines
- Testing requirements
- Pull request process

---

## Documentation

- **[QueryBuilder.md](docs/QueryBuilder.md)** - Complete query builder reference with examples
- **[sorting-and-filtering.md](docs/sorting-and-filtering.md)** - Sorting, filtering, and pagination examples

---

## License

MIT License — see [LICENSE.md](LICENSE.md) for details.

---

## Disclaimer

This SDK is **unofficial** and not affiliated with [DataCite](https://datacite.org/).

- Use at your own risk
- Respect DataCite API rate limits and terms of service
- Ensure proper authentication and security for member API credentials
- Always test in a non-production environment first

For official DataCite documentation, visit [support.datacite.org/docs](https://support.datacite.org/docs/api).
