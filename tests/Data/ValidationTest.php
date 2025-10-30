<?php

declare(strict_types=1);

use VincentAuger\DataCiteSdk\Data\Affiliations\Affiliation;
use VincentAuger\DataCiteSdk\Data\Affiliations\PublisherData;
use VincentAuger\DataCiteSdk\Data\Identifiers\NameIdentifier;
use VincentAuger\DataCiteSdk\Data\Metadata\FundingReference;
use VincentAuger\DataCiteSdk\Exceptions\DataCiteValidationException;

describe('PublisherData validation', function (): void {
    test('throws exception when publisherIdentifier is provided without publisherIdentifierScheme', function (): void {
        $publisher = new PublisherData(
            name: 'Test Publisher',
            lang: null,
            schemeUri: null,
            publisherIdentifier: 'https://ror.org/04z8jg394',
            publisherIdentifierScheme: null,
        );

        expect(fn (): array => $publisher->toArray())
            ->toThrow(DataCiteValidationException::class, 'If publisherIdentifier is used, publisherIdentifierScheme is mandatory.');
    });

    test('throws exception when publisherIdentifierScheme is provided without publisherIdentifier', function (): void {
        $publisher = new PublisherData(
            name: 'Test Publisher',
            lang: null,
            schemeUri: null,
            publisherIdentifier: null,
            publisherIdentifierScheme: 'ROR',
        );

        expect(fn (): array => $publisher->toArray())
            ->toThrow(DataCiteValidationException::class, 'publisherIdentifierScheme cannot be used without publisherIdentifier.');
    });

    test('succeeds when both publisherIdentifier and publisherIdentifierScheme are provided', function (): void {
        $publisher = new PublisherData(
            name: 'Test Publisher',
            lang: 'en',
            schemeUri: 'https://ror.org/',
            publisherIdentifier: 'https://ror.org/04z8jg394',
            publisherIdentifierScheme: 'ROR',
        );

        $array = $publisher->toArray();

        expect($array)->toBeArray()
            ->and($array['name'])->toBe('Test Publisher')
            ->and($array['publisherIdentifier'])->toBe('https://ror.org/04z8jg394')
            ->and($array['publisherIdentifierScheme'])->toBe('ROR');
    });

    test('succeeds when neither publisherIdentifier nor publisherIdentifierScheme are provided', function (): void {
        $publisher = new PublisherData(
            name: 'Test Publisher',
            lang: 'en',
            schemeUri: null,
            publisherIdentifier: null,
            publisherIdentifierScheme: null,
        );

        $array = $publisher->toArray();

        expect($array)->toBeArray()
            ->and($array['name'])->toBe('Test Publisher')
            ->and($array)->not->toHaveKey('publisherIdentifier')
            ->and($array)->not->toHaveKey('publisherIdentifierScheme');
    });
});

describe('Affiliation validation', function (): void {
    test('throws exception when affiliationIdentifier is provided without affiliationIdentifierScheme', function (): void {
        $affiliation = new Affiliation(
            name: 'Test University',
            schemeUri: null,
            affiliationIdentifier: 'https://ror.org/03yrm5c26',
            affiliationIdentifierScheme: null,
        );

        expect(fn (): array => $affiliation->toArray())
            ->toThrow(DataCiteValidationException::class, 'If affiliationIdentifier is used, affiliationIdentifierScheme is mandatory.');
    });

    test('throws exception when affiliationIdentifierScheme is provided without affiliationIdentifier', function (): void {
        $affiliation = new Affiliation(
            name: 'Test University',
            schemeUri: null,
            affiliationIdentifier: null,
            affiliationIdentifierScheme: 'ROR',
        );

        expect(fn (): array => $affiliation->toArray())
            ->toThrow(DataCiteValidationException::class, 'affiliationIdentifierScheme cannot be used without affiliationIdentifier.');
    });

    test('succeeds when both affiliationIdentifier and affiliationIdentifierScheme are provided', function (): void {
        $affiliation = new Affiliation(
            name: 'Test University',
            schemeUri: 'https://ror.org/',
            affiliationIdentifier: 'https://ror.org/03yrm5c26',
            affiliationIdentifierScheme: 'ROR',
        );

        $array = $affiliation->toArray();

        expect($array)->toBeArray()
            ->and($array['name'])->toBe('Test University')
            ->and($array['affiliationIdentifier'])->toBe('https://ror.org/03yrm5c26')
            ->and($array['affiliationIdentifierScheme'])->toBe('ROR');
    });

    test('succeeds when neither affiliationIdentifier nor affiliationIdentifierScheme are provided', function (): void {
        $affiliation = new Affiliation(
            name: 'Test University',
            schemeUri: null,
            affiliationIdentifier: null,
            affiliationIdentifierScheme: null,
        );

        $array = $affiliation->toArray();

        expect($array)->toBeArray()
            ->and($array['name'])->toBe('Test University')
            ->and($array)->not->toHaveKey('affiliationIdentifier')
            ->and($array)->not->toHaveKey('affiliationIdentifierScheme');
    });
});

describe('NameIdentifier validation', function (): void {
    test('throws exception when nameIdentifier is provided without nameIdentifierScheme', function (): void {
        $nameIdentifier = new NameIdentifier(
            schemeUri: null,
            nameIdentifier: 'https://orcid.org/0000-0002-1825-0097',
            nameIdentifierScheme: null,
        );

        expect(fn (): array => $nameIdentifier->toArray())
            ->toThrow(DataCiteValidationException::class, 'If nameIdentifier is used, nameIdentifierScheme is mandatory.');
    });

    test('throws exception when nameIdentifierScheme is provided without nameIdentifier', function (): void {
        $nameIdentifier = new NameIdentifier(
            schemeUri: null,
            nameIdentifier: null,
            nameIdentifierScheme: 'ORCID',
        );

        expect(fn (): array => $nameIdentifier->toArray())
            ->toThrow(DataCiteValidationException::class, 'nameIdentifierScheme cannot be used without nameIdentifier.');
    });

    test('succeeds when both nameIdentifier and nameIdentifierScheme are provided', function (): void {
        $nameIdentifier = new NameIdentifier(
            schemeUri: 'https://orcid.org/',
            nameIdentifier: 'https://orcid.org/0000-0002-1825-0097',
            nameIdentifierScheme: 'ORCID',
        );

        $array = $nameIdentifier->toArray();

        expect($array)->toBeArray()
            ->and($array['nameIdentifier'])->toBe('https://orcid.org/0000-0002-1825-0097')
            ->and($array['nameIdentifierScheme'])->toBe('ORCID');
    });

    test('succeeds when neither nameIdentifier nor nameIdentifierScheme are provided', function (): void {
        $nameIdentifier = new NameIdentifier(
            schemeUri: null,
            nameIdentifier: null,
            nameIdentifierScheme: null,
        );

        $array = $nameIdentifier->toArray();

        expect($array)->toBeArray()
            ->and($array['nameIdentifier'])->toBeNull()
            ->and($array['nameIdentifierScheme'])->toBeNull();
    });
});

describe('FundingReference validation', function (): void {
    test('throws exception when funderIdentifier is provided without funderIdentifierType', function (): void {
        $funding = new FundingReference(
            funderName: 'European Commission',
            funderIdentifier: 'https://doi.org/10.13039/501100000780',
            funderIdentifierType: null,
        );

        expect(fn (): array => $funding->toArray())
            ->toThrow(DataCiteValidationException::class, 'If funderIdentifier is used, funderIdentifierType is mandatory.');
    });

    test('throws exception when funderIdentifierType is provided without funderIdentifier', function (): void {
        $funding = new FundingReference(
            funderName: 'European Commission',
            funderIdentifier: null,
            funderIdentifierType: 'Crossref Funder ID',
        );

        expect(fn (): array => $funding->toArray())
            ->toThrow(DataCiteValidationException::class, 'funderIdentifierType cannot be used without funderIdentifier.');
    });

    test('succeeds when both funderIdentifier and funderIdentifierType are provided', function (): void {
        $funding = new FundingReference(
            funderName: 'European Commission',
            funderIdentifier: 'https://doi.org/10.13039/501100000780',
            funderIdentifierType: 'Crossref Funder ID',
            awardNumber: '282625',
            awardUri: 'https://cordis.europa.eu/project/rcn/100180_en.html',
            awardTitle: 'Test Project',
        );

        $array = $funding->toArray();

        expect($array)->toBeArray()
            ->and($array['funderName'])->toBe('European Commission')
            ->and($array['funderIdentifier'])->toBe('https://doi.org/10.13039/501100000780')
            ->and($array['funderIdentifierType'])->toBe('Crossref Funder ID');
    });

    test('succeeds when neither funderIdentifier nor funderIdentifierType are provided', function (): void {
        $funding = new FundingReference(
            funderName: 'European Commission',
            funderIdentifier: null,
            funderIdentifierType: null,
        );

        $array = $funding->toArray();

        expect($array)->toBeArray()
            ->and($array['funderName'])->toBe('European Commission')
            ->and($array)->not->toHaveKey('funderIdentifier')
            ->and($array)->not->toHaveKey('funderIdentifierType');
    });
});
