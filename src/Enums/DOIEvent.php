<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

enum DOIEvent: string
{
    case PUBLISH = 'publish'; // doi to "findable" state
    case REGISTER = 'register'; // doi to "registered" state
    case HIDE = 'hide'; // doi from "findable" to "registered" state
}
