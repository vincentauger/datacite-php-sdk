<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Enums\DateType;

final readonly class Date
{
    /**
     * @param  string|int  $date  Date in YYYY, YYYY-MM-DD, YYYY-MM-DDThh:mm:ssTZD format or date range (e.g., 2004-03-02/2005-06-02). Years before 0000 must be prefixed with - (e.g., -0054 for 55 BC).
     * @param  DateType  $dateType  The type of date (mandatory when Date is used).
     * @param  string|null  $dateInformation  Specific information about the date. May clarify publication, release, collection details, or dates in ancient history (e.g., "55 BC").
     *
     * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/properties/date/
     * @see https://www.w3.org/TR/NOTE-datetime W3CDTF Date Format
     * @see http://www.ukoln.ac.uk/metadata/dcmi/collection-RKMS-ISO8601/ RKMS-ISO8601 Date Ranges
     */
    public function __construct(
        public string|int $date,
        public DateType $dateType,
        public ?string $dateInformation,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['date']) || is_int($data['date']));
        assert(is_string($data['dateType']));

        return new self(
            date: $data['date'],
            dateType: DateType::from($data['dateType']),
            dateInformation: isset($data['dateInformation']) && is_string($data['dateInformation']) ? $data['dateInformation'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'date' => $this->date,
            'dateType' => $this->dateType->value,
        ];

        if ($this->dateInformation !== null) {
            $array['dateInformation'] = $this->dateInformation;
        }

        return $array;
    }
}
