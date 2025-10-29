# DataCite SDK for PHP (Unofficial)

A modern PHP SDK for the DataCite REST API platform, built for maintainability and clarity using [Saloon](https://docs.saloon.dev) for HTTP integration.

> **Current Status:** Under development. Designed for DOI registration, metadata management, and retrieval operations.

For detailed information on the DataCite API, visit the [docs](https://support.datacite.org/docs/api)

---

## Features

- ✅ PHP 8.4+ with modern syntax (typed properties, readonly, enums, attributes)
- ✅ Clean HTTP layer built on [Saloon](https://docs.saloon.dev)
- ✅ PSR-4 autoloading and testable structure
- ✅ Composer-native and framework-agnostic

---

## Installation

```bash
composer require vincentauger/datacite-php-sdk
```

## Usage

### Initialize the client

```php
use VincentAuger\DataCiteSdk\DataCite;

$datacite = new DataCite(
    baseUrl: 'https://api.datacite.org',
    username: 'your_username',
    password: 'your_password',
);
```

### Fetch a DOI record

```php
use VincentAuger\DataCiteSdk\Requests\Doi\GetDoi;

$request = new GetDoi('10.5438/4k3m-nyvg');
$response = $datacite->send($request);
$doi = $request->createDtoFromResponse($response);

echo $doi->attributes->titles[0]->title;  // Access via typed DTO
echo $doi->attributes->creators[0]->name;
echo $doi->attributes->publicationYear;
```

### Search DOIs

```php
use VincentAuger\DataCiteSdk\Requests\Doi\GetDois;

$request = new GetDois(query: 'climate change');
$response = $datacite->send($request);
$results = $request->createDtoFromResponse($response);

foreach ($results->data as $doi) {
    echo $doi->id . ': ' . $doi->attributes->titles[0]->title . PHP_EOL;
}
```

### Create a new DOI

```php
use VincentAuger\DataCiteSdk\Requests\Doi\PostDoi;
use VincentAuger\DataCiteSdk\Data\DoiAttributes;

$attributes = new DoiAttributes(
    doi: '10.5438/example-doi',
    titles: [/* ... */],
    creators: [/* ... */],
    publisher: 'Example Publisher',
    publicationYear: 2025,
    resourceType: [/* ... */]
);

$request = new PostDoi($attributes);
$response = $datacite->send($request);
$createdDoi = $request->createDtoFromResponse($response);
```

## Configuration

### Public API (Read-Only)

```php
use VincentAuger\DataCiteSdk\DataCite;

// No credentials needed for public API
$datacite = new DataCite();
```

### Member API (Full Access)

```php
use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\ApiVersion;

// Credentials required for member API (create, update, delete operations)
$datacite = new DataCite(
    apiVersion: ApiVersion::MEMBER,
    username: 'your-repository-id',
    password: 'your-repository-password',
    mailto: 'your-email@example.com'
);
```

| Parameter | Description |
|-----------|-------------|
| baseUrl | Base URL of the DataCite API (defaults to `https://api.datacite.org`) |
| apiVersion | `ApiVersion::PUBLIC` (default) or `ApiVersion::MEMBER` |
| username | DataCite repository ID (required for member API) |
| password | DataCite repository password (required for member API) |
| mailto | Your email for User-Agent header (optional but recommended) |

**Note:** Some endpoints (POST, PUT, DELETE) require member API authentication. The SDK will throw a clear exception if you attempt to use these endpoints without proper credentials. See [Member API Authentication](docs/member-api-authentication.md) for details.

## Structure

- **DataCite** – main entry point, wraps Saloon connector
- **Requests** – one Saloon Request per endpoint (e.g., GetDoi, GetDois, PostDoi)
- **Data** – Data DTOs for API responses (e.g., DoiObject, DoiAttributes, DoiResultSet)
- **Tests** – Pest tests

## Roadmap

- [x] Basic client and authentication
- [x] System Heartbeat endpoint `/heartbeat`

### DOI Resource

- [x] Fetch DOI records `GET /dois/{id}`
- [x] Search DOI records `GET /dois`
- [ ] Create DOI records `POST /dois`
- [ ] Update DOI records `PUT /dois/{id}`
- [ ] Delete DOI records `DELETE /dois/{id}`
- [ ] Return DOI activities `GET /dois/{id}/activities`

### DataCite Events

- [ ] Return a list of events `GET /events`
- [ ] Return an even `GET /events/{id}`

## Requirements

- PHP 8.4+
- Composer
- Saloon (installed automatically)

## Contributing

Contributions are welcome! Please see our [Contributing Guide](CONTRIBUTING.md) for details on development setup, testing, and guidelines.

## License

MIT License — see the LICENSE file for details.

## Disclaimer

- This SDK is not affiliated with [DataCite](https://datacite.org/)
- Use at your own risk. Respect your DataCite API usage limits and security requirements.
