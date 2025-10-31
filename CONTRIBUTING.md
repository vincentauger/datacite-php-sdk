# CONTRIBUTING

Contributions are welcome, and are accepted via pull requests.
Please review these guidelines before submitting any pull requests.

## Process

1. Fork the project
1. Create a new branch
1. Code, test, commit and push
1. Open a pull request detailing your changes

## Guidelines

* Please ensure the coding style running `composer lint`.
* Send a coherent commit history, making sure each individual commit in your pull request is meaningful.
* You may need to [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing) to avoid merge conflicts.
* Please remember that we follow [SemVer](http://semver.org/).

## Development Setup

1. **Clone the repository**

   ```bash
   git clone https://github.com/vincentauger/datacite-php-sdk.git
   cd datacite-php-sdk
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Set up environment (optional, for testing against real API)**

By default, the test will use the existing fixtures.

   ```bash
   cp .env.example .env
   # Edit .env with your DataCite API credentials
   ```

## Running Tests

The project uses several tools to ensure code quality:

```bash
# Run all tests and checks
composer test

# Individual tools
composer test:unit      # Pest unit tests
composer test:lint      # Laravel Pint code style check
composer test:types     # PHPStan static analysis
composer test:refactor  # Rector refactoring checks

# Fix code style issues
composer lint           # Apply Laravel Pint fixes
composer refactor       # Apply Rector refactoring
```

## Development Guidelines

### Code Quality Standards

This project follows strict PHP standards to ensure maintainability and quality:

- **PHP 8.4+** syntax only
- `declare(strict_types=1)` in every PHP file
- All classes are `final` unless inheritance is required
- DTOs use `readonly` properties with constructor property promotion
- PSR-12 coding standards (enforced by Laravel Pint)
- Level max PHPStan static analysis
- All public methods must have proper type hints and DocBlocks

### Quality Tools

All quality checks must pass before committing:

```bash
composer test          # Run all checks (lint, unit, types, refactor)
composer test:unit     # Pest unit tests
composer test:types    # PHPStan static analysis (level max)
composer lint          # Laravel Pint code formatting
composer refactor      # Rector automated refactoring
```

---

## Project Structure

Understanding the codebase organization:

```
src/
├── DataCite.php              # Main client/connector
├── Requests/                 # API endpoint request classes
│   ├── DOIs/                 # DOI operations (GET, POST, PUT, DELETE)
│   ├── Events/               # Event operations (GET, list)
│   └── GetHeartbeat.php      # System heartbeat check
├── Data/                     # Response DTOs (Data Transfer Objects)
│   ├── DOIData.php           # Single DOI response
│   ├── ListDOIData.php       # Paginated DOI list response
│   ├── EventData.php         # Single event response
│   ├── ListEventData.php     # Paginated event list response
│   ├── CreateDOIInput.php    # DOI creation input
│   ├── UpdateDOIInput.php    # DOI update input
│   └── Metadata/             # Metadata DTOs (titles, creators, etc.)
├── Enums/                    # Type-safe enumerations
│   ├── ApiVersion.php        # PUBLIC vs MEMBER API
│   ├── DOIEvent.php          # publish, register, hide
│   ├── ResourceTypeGeneral.php
│   ├── SortOption.php        # DOI sorting options
│   ├── EventSortOption.php   # Event sorting options
│   └── QueryField.php        # QueryBuilder field names
├── Query/                    # Query builder for advanced searches
│   └── QueryBuilder.php      # Fluent query interface
├── Traits/                   # Shared functionality
│   └── Requests/             # Request traits
│       ├── HasPaginationParams.php
│       ├── HasSortParams.php
│       └── RequiresMemberAuth.php
└── Exceptions/
    └── DataCiteValidationException.php
```

### Architecture Patterns

**Requests**
- Extend `Saloon\Http\Request`
- Must be `final` classes
- Use traits for shared functionality (pagination, sorting, auth)
- Member-only requests use `RequiresMemberAuth` trait

**Data Transfer Objects (DTOs)**
- All DTOs are `final readonly` classes
- Use constructor property promotion
- Implement `fromArray()` static factory methods
- Located in `src/Data/` directory

**Enums**
- All enums are backed enums (string or int)
- Provide type-safe constants for API values
- Located in `src/Enums/` directory

---

## Adding New Features

### Adding a New Request

1. Create request class in appropriate `Requests/` subdirectory
2. Extend `Saloon\Http\Request`
3. Define HTTP method and endpoint
4. Add appropriate traits (pagination, sorting, auth)
5. Create corresponding DTO if needed
6. Add tests in `tests/Requests/`
7. Add fixture in `tests/Fixtures/Saloon/`

**Example:**

```php
<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Requests\DOIs;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class GetDOI extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private string $doi) {}

    public function resolveEndpoint(): string
    {
        return '/dois/' . $this->doi;
    }
}
```

### Adding a New DTO

1. Create DTO class in `src/Data/`
2. Make it `final readonly`
3. Use constructor property promotion
4. Add `fromArray()` static factory method
5. Add proper type hints and DocBlocks

**Example:**

```php
<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

final readonly class ExampleData
{
    public function __construct(
        public string $id,
        public string $type,
        public ExampleAttributes $attributes,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type'],
            attributes: ExampleAttributes::fromArray($data['attributes']),
        );
    }
}
```

### Adding a New Enum

1. Create enum in `src/Enums/`
2. Make it a backed enum (string or int)
3. Add descriptive case names
4. Document expected API values

**Example:**

```php
<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

enum ExampleType: string
{
    case TYPE_ONE = 'type-one';
    case TYPE_TWO = 'type-two';
}
```
