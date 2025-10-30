<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Exceptions;

use InvalidArgumentException;

/**
 * Exception thrown when DataCite metadata validation fails.
 *
 * This exception is used to enforce conditional dependencies defined
 * in the DataCite Metadata Schema 4.6, such as requiring an identifier
 * scheme when an identifier is provided.
 */
final class DataCiteValidationException extends InvalidArgumentException {}
