<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {

        parent::setUpBeforeClass();

        // check if the .env file exists and load it
        $envExists = file_exists(__DIR__.'/../.env');

        // load environment variables for testing against the test API
        if ($envExists) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../');
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
}
