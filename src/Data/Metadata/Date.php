<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class Date
{
    public function __construct(
        public string|int $date,
        public string $dateType,
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
            dateType: $data['dateType'],
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
            'dateType' => $this->dateType,
        ];

        if ($this->dateInformation !== null) {
            $array['dateInformation'] = $this->dateInformation;
        }

        return $array;
    }
}
