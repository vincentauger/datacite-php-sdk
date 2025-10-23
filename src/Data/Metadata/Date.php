<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class Date
{
    public function __construct(
        public string $date,
        public string $dateType,
        public ?string $dateInformation,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            date: $data['date'],
            dateType: $data['dateType'],
            dateInformation: $data['dateInformation'] ?? null,
        );
    }

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
