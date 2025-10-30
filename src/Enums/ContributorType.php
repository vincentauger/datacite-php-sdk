<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite ContributorType controlled vocabulary.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/appendices/appendix-1/contributorType/
 */
enum ContributorType: string
{
    case CONTACT_PERSON = 'ContactPerson';
    case DATA_COLLECTOR = 'DataCollector';
    case DATA_CURATOR = 'DataCurator';
    case DATA_MANAGER = 'DataManager';
    case DISTRIBUTOR = 'Distributor';
    case EDITOR = 'Editor';
    case HOSTING_INSTITUTION = 'HostingInstitution';
    case PRODUCER = 'Producer';
    case PROJECT_LEADER = 'ProjectLeader';
    case PROJECT_MANAGER = 'ProjectManager';
    case PROJECT_MEMBER = 'ProjectMember';
    case REGISTRATION_AGENCY = 'RegistrationAgency';
    case REGISTRATION_AUTHORITY = 'RegistrationAuthority';
    case RELATED_PERSON = 'RelatedPerson';
    case RESEARCHER = 'Researcher';
    case RESEARCH_GROUP = 'ResearchGroup';
    case RIGHTS_HOLDER = 'RightsHolder';
    case SPONSOR = 'Sponsor';
    case SUPERVISOR = 'Supervisor';
    case TRANSLATOR = 'Translator';
    case WORK_PACKAGE_LEADER = 'WorkPackageLeader';
    case OTHER = 'Other';
}
