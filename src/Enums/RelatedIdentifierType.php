<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite RelatedIdentifierType controlled vocabulary.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/properties/relatedidentifier/#a-relatedidentifiertype
 */
enum RelatedIdentifierType: string
{
    case ARK = 'ARK';
    case ARXIV = 'arXiv';
    case BIBCODE = 'bibcode';
    case CSTR = 'CSTR';
    case DOI = 'DOI';
    case EAN13 = 'EAN13';
    case EISSN = 'EISSN';
    case HANDLE = 'Handle';
    case IGSN = 'IGSN';
    case ISBN = 'ISBN';
    case ISSN = 'ISSN';
    case ISTC = 'ISTC';
    case LISSN = 'LISSN';
    case LSID = 'LSID';
    case PMID = 'PMID';
    case PURL = 'PURL';
    case RRID = 'RRID';
    case UPC = 'UPC';
    case URL = 'URL';
    case URN = 'URN';
    case W3ID = 'w3id';
}
