<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite DateType controlled vocabulary.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/appendices/appendix-1/dateType/
 */
enum DateType: string
{
    case ACCEPTED = 'Accepted';
    case AVAILABLE = 'Available';
    case COPYRIGHTED = 'Copyrighted';
    case COLLECTED = 'Collected';
    case COVERAGE = 'Coverage';
    case CREATED = 'Created';
    case ISSUED = 'Issued';
    case SUBMITTED = 'Submitted';
    case UPDATED = 'Updated';
    case VALID = 'Valid';
    case WITHDRAWN = 'Withdrawn';
    case OTHER = 'Other';
}
