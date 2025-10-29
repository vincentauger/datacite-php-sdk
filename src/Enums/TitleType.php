<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

enum TitleType: string
{
    case ALTERNATIVE_TITLE = 'AlternativeTitle';
    case SUBTITLE = 'Subtitle';
    case TRANSLATED_TITLE = 'TranslatedTitle';
    case OTHER = 'Other';
}
