<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite DescriptionType controlled vocabulary.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/appendices/appendix-1/descriptionType/
 */
enum DescriptionType: string
{
    case ABSTRACT = 'Abstract';
    case METHODS = 'Methods';
    case SERIES_INFORMATION = 'SeriesInformation';
    case TABLE_OF_CONTENTS = 'TableOfContents';
    case TECHNICAL_INFO = 'TechnicalInfo';
    case OTHER = 'Other';
}
