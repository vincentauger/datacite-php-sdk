<?php

declare(strict_types=1);

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\ApiVersion;

class BaseTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {

        parent::setUpBeforeClass();

        // check if the .env file exists and load it
        $envExists = file_exists(__DIR__.'/../.env');

        // load environment variables for testing against the test API
        if ($envExists) {
            $dotenv = Dotenv::createImmutable(__DIR__.'/../');
            $dotenv->load();
            echo "Loaded .env file\n";
            // fail test if the base url is not the test API
            $baseUrl = $_ENV['DATACITE_BASE_URL'];
            if ($baseUrl !== 'https://api.test.datacite.org') {
                self::fail('Base URL is not set to the test API. Please set DATACITE_BASE_URL to https://api.test.datacite.org in your .env file.');
            }
        } else {
            echo "Skipped .env loading\n";
        }

    }

    public function getPublicApiClient(?string $email = null, bool $prodApi = false): DataCite
    {
        $baseUrl = $_ENV['DATACITE_BASE_URL'] ?? 'https://api.test.datacite.org';
        $baseUrl = $prodApi ? 'https://api.datacite.org' : $baseUrl;

        return new DataCite(baseUrl: $baseUrl, mailto: $email);
    }

    public function getMemberApiClient(): DataCite
    {
        $baseUrl = $_ENV['DATACITE_BASE_URL'] ?? 'https://api.test.datacite.org';
        $username = $_ENV['DATACITE_USERNAME'] ?? 'username';
        $password = $_ENV['DATACITE_PASSWORD'] ?? 'password';
        $mailto = $_ENV['DATACITE_MAILTO'] ?? null;

        if (! $username || ! $password) {
            self::fail('DATACITE_USERNAME and DATACITE_PASSWORD must be set in the .env file for member API tests.');
        }

        return new DataCite(
            baseUrl: $baseUrl,
            apiVersion: ApiVersion::MEMBER,
            username: $username,
            password: $password,
            mailto: $mailto
        );
    }
}
