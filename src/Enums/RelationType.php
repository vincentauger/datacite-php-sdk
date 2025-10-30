<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite RelationType controlled vocabulary.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/properties/relatedidentifier/#b-relationtype
 */
enum RelationType: string
{
    case IS_CITED_BY = 'IsCitedBy';
    case CITES = 'Cites';
    case IS_SUPPLEMENT_TO = 'IsSupplementTo';
    case IS_SUPPLEMENTED_BY = 'IsSupplementedBy';
    case IS_CONTINUED_BY = 'IsContinuedBy';
    case CONTINUES = 'Continues';
    case IS_DESCRIBED_BY = 'IsDescribedBy';
    case DESCRIBES = 'Describes';
    case HAS_METADATA = 'HasMetadata';
    case IS_METADATA_FOR = 'IsMetadataFor';
    case HAS_VERSION = 'HasVersion';
    case IS_VERSION_OF = 'IsVersionOf';
    case IS_NEW_VERSION_OF = 'IsNewVersionOf';
    case IS_PREVIOUS_VERSION_OF = 'IsPreviousVersionOf';
    case IS_PART_OF = 'IsPartOf';
    case HAS_PART = 'HasPart';
    case IS_PUBLISHED_IN = 'IsPublishedIn';
    case IS_REFERENCED_BY = 'IsReferencedBy';
    case REFERENCES = 'References';
    case IS_DOCUMENTED_BY = 'IsDocumentedBy';
    case DOCUMENTS = 'Documents';
    case IS_COMPILED_BY = 'IsCompiledBy';
    case COMPILES = 'Compiles';
    case IS_VARIANT_FORM_OF = 'IsVariantFormOf';
    case IS_ORIGINAL_FORM_OF = 'IsOriginalFormOf';
    case IS_IDENTICAL_TO = 'IsIdenticalTo';
    case IS_REVIEWED_BY = 'IsReviewedBy';
    case REVIEWS = 'Reviews';
    case IS_DERIVED_FROM = 'IsDerivedFrom';
    case IS_SOURCE_OF = 'IsSourceOf';
    case IS_REQUIRED_BY = 'IsRequiredBy';
    case REQUIRES = 'Requires';
    case IS_OBSOLETED_BY = 'IsObsoletedBy';
    case OBSOLETES = 'Obsoletes';
    case IS_COLLECTED_BY = 'IsCollectedBy';
    case COLLECTS = 'Collects';
    case IS_TRANSLATION_OF = 'IsTranslationOf';
    case HAS_TRANSLATION = 'HasTranslation';
}
