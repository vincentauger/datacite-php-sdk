<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite Event Relation Type identifiers.
 *
 * Includes both standard relation types and usage metrics.
 */
enum EventRelationType: string
{
    // Standard relation types (kebab-case)
    case IS_CITED_BY = 'is-cited-by';
    case CITES = 'cites';
    case IS_SUPPLEMENT_TO = 'is-supplement-to';
    case IS_SUPPLEMENTED_BY = 'is-supplemented-by';
    case IS_CONTINUED_BY = 'is-continued-by';
    case CONTINUES = 'continues';
    case IS_DESCRIBED_BY = 'is-described-by';
    case DESCRIBES = 'describes';
    case HAS_METADATA = 'has-metadata';
    case IS_METADATA_FOR = 'is-metadata-for';
    case HAS_VERSION = 'has-version';
    case IS_VERSION_OF = 'is-version-of';
    case IS_NEW_VERSION_OF = 'is-new-version-of';
    case IS_PREVIOUS_VERSION_OF = 'is-previous-version-of';
    case IS_PART_OF = 'is-part-of';
    case HAS_PART = 'has-part';
    case IS_PUBLISHED_IN = 'is-published-in';
    case IS_REFERENCED_BY = 'is-referenced-by';
    case REFERENCES = 'references';
    case IS_DOCUMENTED_BY = 'is-documented-by';
    case DOCUMENTS = 'documents';
    case IS_COMPILED_BY = 'is-compiled-by';
    case COMPILES = 'compiles';
    case IS_VARIANT_FORM_OF = 'is-variant-form-of';
    case IS_ORIGINAL_FORM_OF = 'is-original-form-of';
    case IS_IDENTICAL_TO = 'is-identical-to';
    case IS_REVIEWED_BY = 'is-reviewed-by';
    case REVIEWS = 'reviews';
    case IS_DERIVED_FROM = 'is-derived-from';
    case IS_SOURCE_OF = 'is-source-of';
    case IS_REQUIRED_BY = 'is-required-by';
    case REQUIRES = 'requires';
    case IS_OBSOLETED_BY = 'is-obsoleted-by';
    case OBSOLETES = 'obsoletes';
    case IS_COLLECTED_BY = 'is-collected-by';
    case COLLECTS = 'collects';
    case IS_AUTHORED_BY = 'is-authored-by';
    case IS_AUTHORED_AT = 'is-authored-at';
    case IS_FUNDED_BY = 'is-funded-by';

    // Usage metrics
    case TOTAL_DATASET_INVESTIGATIONS_REGULAR = 'total-dataset-investigations-regular';
    case UNIQUE_DATASET_INVESTIGATIONS_REGULAR = 'unique-dataset-investigations-regular';
    case TOTAL_DATASET_REQUESTS_REGULAR = 'total-dataset-requests-regular';
    case UNIQUE_DATASET_REQUESTS_REGULAR = 'unique-dataset-requests-regular';
    case TOTAL_DATASET_INVESTIGATIONS_MACHINE = 'total-dataset-investigations-machine';
    case UNIQUE_DATASET_INVESTIGATIONS_MACHINE = 'unique-dataset-investigations-machine';
    case TOTAL_DATASET_REQUESTS_MACHINE = 'total-dataset-requests-machine';
    case UNIQUE_DATASET_REQUESTS_MACHINE = 'unique-dataset-requests-machine';
}
