<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite ResourceTypeGeneral controlled vocabulary.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/properties/resourcetype/#resourcetypegeneral
 */
enum ResourceTypeGeneral: string
{
    case AUDIOVISUAL = 'Audiovisual';
    case AWARD = 'Award';
    case BOOK = 'Book';
    case BOOK_CHAPTER = 'BookChapter';
    case COLLECTION = 'Collection';
    case COMPUTATIONAL_NOTEBOOK = 'ComputationalNotebook';
    case CONFERENCE_PAPER = 'ConferencePaper';
    case CONFERENCE_PROCEEDING = 'ConferenceProceeding';
    case DATA_PAPER = 'DataPaper';
    case DATASET = 'Dataset';
    case DISSERTATION = 'Dissertation';
    case EVENT = 'Event';
    case IMAGE = 'Image';
    case INTERACTIVE_RESOURCE = 'InteractiveResource';
    case INSTRUMENT = 'Instrument';
    case JOURNAL = 'Journal';
    case JOURNAL_ARTICLE = 'JournalArticle';
    case MODEL = 'Model';
    case OUTPUT_MANAGEMENT_PLAN = 'OutputManagementPlan';
    case PEER_REVIEW = 'PeerReview';
    case PHYSICAL_OBJECT = 'PhysicalObject';
    case PREPRINT = 'Preprint';
    case PROJECT = 'Project';
    case REPORT = 'Report';
    case SERVICE = 'Service';
    case SOFTWARE = 'Software';
    case SOUND = 'Sound';
    case STANDARD = 'Standard';
    case STUDY_REGISTRATION = 'StudyRegistration';
    case TEXT = 'Text';
    case WORKFLOW = 'Workflow';
    case OTHER = 'Other';
}
