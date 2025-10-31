<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * Supported metadata field names for DataCite REST API queries.
 *
 * @see https://support.datacite.org/docs/api-queries
 */
enum QueryField: string
{
    // DOI
    case DOI = 'doi';

    // Creators
    case CREATORS_NAME = 'creators.name';
    case CREATORS_LANG = 'creators.lang';
    case CREATORS_NAME_TYPE = 'creators.nameType';
    case CREATORS_GIVEN_NAME = 'creators.givenName';
    case CREATORS_FAMILY_NAME = 'creators.familyName';
    case CREATORS_NAME_IDENTIFIER = 'creators.nameIdentifiers.nameIdentifier';
    case CREATORS_NAME_IDENTIFIER_SCHEME = 'creators.nameIdentifiers.nameIdentifierScheme';
    case CREATORS_NAME_IDENTIFIER_SCHEME_URI = 'creators.nameIdentifiers.schemeUri';
    case CREATORS_AFFILIATION_NAME = 'creators.affiliation.name';
    case CREATORS_AFFILIATION_IDENTIFIER = 'creators.affiliation.affiliationIdentifier';
    case CREATORS_AFFILIATION_IDENTIFIER_SCHEME = 'creators.affiliation.affiliationIdentifierScheme';
    case CREATORS_AFFILIATION_SCHEME_URI = 'creators.affiliation.schemeUri';

    // Titles
    case TITLES_TITLE = 'titles.title';
    case TITLES_LANG = 'titles.lang';
    case TITLES_TITLE_TYPE = 'titles.titleType';

    // Publisher
    case PUBLISHER = 'publisher';
    case PUBLISHER_NAME = 'publisher.name';
    case PUBLISHER_IDENTIFIER = 'publisher.publisherIdentifier';
    case PUBLISHER_IDENTIFIER_SCHEME = 'publisher.publisherIdentifierScheme';
    case PUBLISHER_SCHEME_URI = 'publisher.schemeUri';
    case PUBLISHER_LANG = 'publisher.lang';

    // Publication Year
    case PUBLICATION_YEAR = 'publicationYear';

    // Subjects
    case SUBJECTS_SUBJECT = 'subjects.subject';
    case SUBJECTS_SUBJECT_SCHEME = 'subjects.subjectScheme';
    case SUBJECTS_SCHEME_URI = 'subjects.schemeUri';
    case SUBJECTS_VALUE_URI = 'subjects.valueUri';
    case SUBJECTS_CLASSIFICATION_CODE = 'subjects.classificationCode';
    case SUBJECTS_LANG = 'subjects.lang';

    // Contributors
    case CONTRIBUTORS_CONTRIBUTOR_TYPE = 'contributors.contributorType';
    case CONTRIBUTORS_NAME = 'contributors.name';
    case CONTRIBUTORS_LANG = 'contributors.lang';
    case CONTRIBUTORS_NAME_TYPE = 'contributors.nameType';
    case CONTRIBUTORS_GIVEN_NAME = 'contributors.givenName';
    case CONTRIBUTORS_FAMILY_NAME = 'contributors.familyName';
    case CONTRIBUTORS_NAME_IDENTIFIER = 'contributors.nameIdentifiers.nameIdentifier';
    case CONTRIBUTORS_NAME_IDENTIFIER_SCHEME = 'contributors.nameIdentifiers.nameIdentifierScheme';
    case CONTRIBUTORS_NAME_IDENTIFIER_SCHEME_URI = 'contributors.nameIdentifiers.schemeUri';
    case CONTRIBUTORS_AFFILIATION_NAME = 'contributors.affiliation.name';
    case CONTRIBUTORS_AFFILIATION_IDENTIFIER = 'contributors.affiliation.affiliationIdentifier';
    case CONTRIBUTORS_AFFILIATION_IDENTIFIER_SCHEME = 'contributors.affiliation.affiliationIdentifierScheme';
    case CONTRIBUTORS_AFFILIATION_SCHEME_URI = 'contributors.affiliation.schemeUri';

    // Dates
    case DATES_DATE = 'dates.date';
    case DATES_DATE_TYPE = 'dates.dateType';
    case DATES_DATE_INFORMATION = 'dates.dateInformation';

    // Language
    case LANGUAGE = 'language';

    // Types
    case TYPES_RESOURCE_TYPE = 'types.resourceType';
    case TYPES_RESOURCE_TYPE_GENERAL = 'types.resourceTypeGeneral';

    // Alternate Identifiers
    case ALTERNATE_IDENTIFIERS_ALTERNATE_IDENTIFIER = 'alternateIdentifiers.alternateIdentifier';
    case ALTERNATE_IDENTIFIERS_ALTERNATE_IDENTIFIER_TYPE = 'alternateIdentifiers.alternateIdentifierType';
    case IDENTIFIERS_IDENTIFIER = 'identifiers.identifier';
    case IDENTIFIERS_IDENTIFIER_TYPE = 'identifiers.identifierType';

    // Related Identifiers
    case RELATED_IDENTIFIERS_RELATED_IDENTIFIER = 'relatedIdentifiers.relatedIdentifier';
    case RELATED_IDENTIFIERS_RELATED_IDENTIFIER_TYPE = 'relatedIdentifiers.relatedIdentifierType';
    case RELATED_IDENTIFIERS_RELATION_TYPE = 'relatedIdentifiers.relationType';
    case RELATED_IDENTIFIERS_RELATED_METADATA_SCHEME = 'relatedIdentifiers.relatedMetadataScheme';
    case RELATED_IDENTIFIERS_SCHEME_URI = 'relatedIdentifiers.schemeUri';
    case RELATED_IDENTIFIERS_SCHEME_TYPE = 'relatedIdentifiers.schemeType';
    case RELATED_IDENTIFIERS_RESOURCE_TYPE_GENERAL = 'relatedIdentifiers.resourceTypeGeneral';

    // Sizes
    case SIZES = 'sizes';

    // Formats
    case FORMATS = 'formats';

    // Version
    case VERSION = 'version';

    // Rights List
    case RIGHTS_LIST_RIGHTS = 'rightsList.rights';
    case RIGHTS_LIST_LANG = 'rightsList.lang';
    case RIGHTS_LIST_RIGHTS_URI = 'rightsList.rightsUri';
    case RIGHTS_LIST_RIGHTS_IDENTIFIER = 'rightsList.rightsIdentifier';
    case RIGHTS_LIST_RIGHTS_IDENTIFIER_SCHEME = 'rightsList.rightsIdentifierScheme';
    case RIGHTS_LIST_SCHEME_URI = 'rightsList.schemeUri';

    // Descriptions
    case DESCRIPTIONS_DESCRIPTION = 'descriptions.description';
    case DESCRIPTIONS_LANG = 'descriptions.lang';
    case DESCRIPTIONS_DESCRIPTION_TYPE = 'descriptions.descriptionType';

    // Geo Locations
    case GEO_LOCATIONS_GEO_LOCATION_PLACE = 'geoLocations.geoLocationPlace';

    // Funding References
    case FUNDING_REFERENCES_FUNDER_NAME = 'fundingReferences.funderName';
    case FUNDING_REFERENCES_FUNDER_IDENTIFIER = 'fundingReferences.funderIdentifier';
    case FUNDING_REFERENCES_FUNDER_IDENTIFIER_TYPE = 'fundingReferences.funderIdentifierType';
    case FUNDING_REFERENCES_SCHEME_URI = 'fundingReferences.schemeUri';
    case FUNDING_REFERENCES_AWARD_NUMBER = 'fundingReferences.awardNumber';
    case FUNDING_REFERENCES_AWARD_URI = 'fundingReferences.awardUri';
    case FUNDING_REFERENCES_AWARD_TITLE = 'fundingReferences.awardTitle';

    // Related Items
    case RELATED_ITEMS_RELATED_ITEM_TYPE = 'relatedItems.relatedItemType';
    case RELATED_ITEMS_RELATION_TYPE = 'relatedItems.relationType';
    case RELATED_ITEMS_RELATED_ITEM_IDENTIFIER = 'relatedItems.relatedItemIdentifier.relatedItemIdentifier';
    case RELATED_ITEMS_RELATED_ITEM_IDENTIFIER_TYPE = 'relatedItems.relatedItemIdentifier.relatedItemIdentifierType';
    case RELATED_ITEMS_RELATED_METADATA_SCHEME = 'relatedItems.relatedItemIdentifier.relatedMetadataScheme';
    case RELATED_ITEMS_SCHEME_URI = 'relatedItems.relatedItemIdentifier.schemeURI';
    case RELATED_ITEMS_SCHEME_TYPE = 'relatedItems.relatedItemIdentifier.schemeType';
    case RELATED_ITEMS_CREATORS_NAME = 'relatedItems.creators.name';
    case RELATED_ITEMS_CREATORS_NAME_TYPE = 'relatedItems.creators.nameType';
    case RELATED_ITEMS_CREATORS_GIVEN_NAME = 'relatedItems.creators.givenName';
    case RELATED_ITEMS_CREATORS_FAMILY_NAME = 'relatedItems.creators.familyName';
    case RELATED_ITEMS_TITLES_TITLE = 'relatedItems.titles.title';
    case RELATED_ITEMS_TITLES_LANG = 'relatedItems.titles.lang';
    case RELATED_ITEMS_TITLES_TITLE_TYPE = 'relatedItems.titles.titleType';
    case RELATED_ITEMS_PUBLICATION_YEAR = 'relatedItems.publicationYear';
    case RELATED_ITEMS_VOLUME = 'relatedItems.volume';
    case RELATED_ITEMS_ISSUE = 'relatedItems.issue';
    case RELATED_ITEMS_NUMBER = 'relatedItems.number';
    case RELATED_ITEMS_NUMBER_TYPE = 'relatedItems.numberType';
    case RELATED_ITEMS_FIRST_PAGE = 'relatedItems.firstPage';
    case RELATED_ITEMS_LAST_PAGE = 'relatedItems.lastPage';
    case RELATED_ITEMS_PUBLISHER = 'relatedItems.publisher';
    case RELATED_ITEMS_EDITION = 'relatedItems.edition';
    case RELATED_ITEMS_CONTRIBUTORS_CONTRIBUTOR_TYPE = 'relatedItems.contributors.contributorType';
    case RELATED_ITEMS_CONTRIBUTORS_NAME = 'relatedItems.contributors.name';
    case RELATED_ITEMS_CONTRIBUTORS_NAME_TYPE = 'relatedItems.contributors.nameType';
    case RELATED_ITEMS_CONTRIBUTORS_GIVEN_NAME = 'relatedItems.contributors.givenName';
    case RELATED_ITEMS_CONTRIBUTORS_FAMILY_NAME = 'relatedItems.contributors.familyName';
}
