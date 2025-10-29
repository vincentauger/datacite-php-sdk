# DataCite PHP SDK Instructions

## Project Overview

This is a modern PHP SDK for the DataCite REST API platform, built for maintainability and clarity using Saloon for HTTP integration. Supports DOI registration, metadata management, and retrieval operations.

## Core Rules

- Use PHP 8.4+ syntax only
- Add `declare(strict_types=1);` to every PHP file
- Make all classes final unless inheritance is required
- Use readonly properties wherever possible
- Use constructor property promotion
- Use typed properties and return types
- Follow PSR-12 coding standards
- Never use `var_dump()` or `dd()` in production code

## Namespaces

- Base: `VincentAuger\DataCiteSdk`
- Data: `VincentAuger\DataCiteSdk\Data`
- Requests: `VincentAuger\DataCiteSdk\Requests`
- Enums: `VincentAuger\DataCiteSdk\Enums`

## Class Requirements

- DTOs are `final readonly`
- Requests extend `Saloon\Http\Request`
- Requests are `final`
- Enums are backed enums with string or int values
- Use traits for shared functionality (see `Traits/` directory)
- Member-only requests must use `RequiresMemberAuth` trait

## Architecture

- Built on Saloon HTTP client framework
- DataCite.php is the main client entry point
- Requests/ contains Saloon request classes organized by API endpoint
- Data/ contains DTOs for API responses
- All responses should be typed using Data DTOs

## Testing & Quality Tools

Run these commands before committing:

- `composer test` - runs all tests (lint, unit, types, refactor)
- `composer lint` - Laravel Pint code formatting
- `composer test:unit` - Pest unit tests
- `composer test:types` - PHPStan static analysis
- `composer refactor` - Rector code improvements

## Common Patterns

- Use constructor property promotion for DTOs
- Implement request traits for shared parameters (HasPaginationParams, HasFieldParams, HasIdParams)
- Follow existing naming conventions in Data/ classes
- Use typed arrays in DocBlocks: `@var DoiObject[]`

## Member API Authentication

The DataCite API has two access levels:

1. **Public API** (default) - Read-only access, no auth required (GET endpoints)
2. **Member API** - Full access including create/update/delete (POST/PUT/DELETE endpoints)

### When to Require Member Auth

Add the `RequiresMemberAuth` trait to any request class that:
- Uses POST, PUT, or DELETE methods
- Accesses member-specific data
- Modifies DOI records

### Example

```php
use VincentAuger\DataCiteSdk\Traits\Requests\RequiresMemberAuth;

/**
 * Create a new DOI
 * 
 * This endpoint requires member API authentication.
 */
final class CreateDOI extends Request
{
    use RequiresMemberAuth;  // Enforces member auth requirement
    
    protected Method $method = Method::POST;
    // ...
}
```

See [docs/member-api-authentication.md](docs/member-api-authentication.md) for complete details.

