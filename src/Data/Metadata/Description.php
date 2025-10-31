<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Enums\DescriptionType;

/**
 * Represents DataCite Property 17: Description
 *
 * All additional information that does not fit in any other categories.
 * May be used for technical information or detailed information associated with a scientific instrument.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/properties/description/
 */
final readonly class Description
{
    /**
     * @param  string|null  $lang  Language code (e.g., "en", "fr"). Recommended to follow W3C language tag standards.
     * @param  string  $description  Free text description. Use "<br>" to indicate line breaks for improved rendering, but otherwise avoid HTML markup.
     * @param  DescriptionType  $descriptionType  The type of description (mandatory when Description is used).
     *
     * @see https://www.w3.org/International/questions/qa-choosing-language-tags W3C Language Tags
     */
    public function __construct(
        public ?string $lang,
        public string $description,
        public DescriptionType $descriptionType,
    ) {}

    /**
     * Create from array, lenient parsing for API responses.
     * Returns null if required fields are missing (description or descriptionType).
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): ?self
    {
        // Skip invalid descriptions from API responses (legacy/incomplete data)
        if (! isset($data['description']) || ! is_string($data['description']) || $data['description'] === '') {
            return null;
        }

        if (! isset($data['descriptionType']) || ! is_string($data['descriptionType']) || $data['descriptionType'] === '') {
            return null;
        }

        return new self(
            lang: isset($data['lang']) && is_string($data['lang']) ? $data['lang'] : null,
            description: $data['description'],
            descriptionType: DescriptionType::from($data['descriptionType']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'description' => $this->description,
            'descriptionType' => $this->descriptionType->value,
        ];

        if ($this->lang !== null) {
            $array['lang'] = $this->lang;
        }

        return $array;
    }
}
