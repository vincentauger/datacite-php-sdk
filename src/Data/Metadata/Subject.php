<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class Subject
{
    public function __construct(
        public string $subject,
        public ?string $subjectScheme = null,
        public ?string $schemeUri = null,
        public ?string $valueUri = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            subject: $data['subject'],
            subjectScheme: $data['subjectScheme'] ?? null,
            schemeUri: $data['schemeUri'] ?? null,
            valueUri: $data['valueUri'] ?? null,
        );
    }

    public function toArray(): array
    {
        $array = ['subject' => $this->subject];

        if ($this->subjectScheme !== null) {
            $array['subjectScheme'] = $this->subjectScheme;
        }

        if ($this->schemeUri !== null) {
            $array['schemeUri'] = $this->schemeUri;
        }

        if ($this->valueUri !== null) {
            $array['valueUri'] = $this->valueUri;
        }

        return $array;
    }
}
