<?php

require_once 'vendor/autoload.php';

use VincentAuger\DataCiteSdk\DataCite;
use VincentAuger\DataCiteSdk\Enums\SortDirection;
use VincentAuger\DataCiteSdk\Enums\SortOption;
use VincentAuger\DataCiteSdk\Query\QueryBuilder;
use VincentAuger\DataCiteSdk\Requests\DOIs\ListDOIs;

// Example usage of the new sorting functionality

// Create the client
$client = DataCite::public();

// Sort by name ascending
$request1 = ListDOIs::new()
    ->withSortAsc(SortOption::NAME);

// Sort by created date descending
$request2 = ListDOIs::new()
    ->withSortDesc(SortOption::CREATED);

// Sort by relevance (always descending)
$request3 = ListDOIs::new()
    ->withSort(SortOption::RELEVANCE);

// Sort with explicit direction
$request4 = ListDOIs::new()
    ->withSort(SortOption::TITLE, SortDirection::ASC);

// Filter by provider
$request5 = ListDOIs::new()
    ->withProviderId('cern')
    ->withSortDesc(SortOption::CREATED);

// Filter by client with QueryBuilder
$request6 = ListDOIs::new()
    ->withClientId('cern.zenodo')
    ->withQuery(
        QueryBuilder::new()
            ->whereEquals('publicationYear', '2023')
    )
    ->withSortDesc(SortOption::PUBLISHED);

// Complex example with multiple filters
$request7 = ListDOIs::new()
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

echo "Sorting and filter examples created successfully!\n";
echo "Available sort options:\n";
foreach (SortOption::cases() as $option) {
    echo "- {$option->value}\n";
}
