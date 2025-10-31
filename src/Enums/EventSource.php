<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite Event Source identifiers.
 *
 * Identifies the source system that generated the event.
 */
enum EventSource: string
{
    case DATACITE_USAGE = 'datacite-usage';
    case DATACITE_RELATED = 'datacite-related';
    case DATACITE_CROSSREF = 'datacite-crossref';
    case DATACITE_KISTI = 'datacite-kisti';
    case DATACITE_OP = 'datacite-op';
    case DATACITE_MEDRA = 'datacite-medra';
    case DATACITE_ISTIC = 'datacite-istic';
    case DATACITE_FUNDER = 'datacite-funder';
    case DATACITE_ORCID_AUTO_UPDATE = 'datacite-orcid-auto-update';
    case DATACITE_URL = 'datacite-url';
    case CROSSREF = 'crossref';
}
