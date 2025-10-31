<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Enums;

/**
 * DataCite Event Message Action types.
 *
 * Indicates the action performed on the event.
 */
enum EventMessageAction: string
{
    case CREATE = 'create';
    case ADD = 'add';
}
