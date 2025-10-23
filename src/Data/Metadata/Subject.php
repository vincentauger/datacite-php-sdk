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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['subject']));

        return new self(
            subject: $data['subject'],
            subjectScheme: isset($data['subjectScheme']) && is_string($data['subjectScheme']) ? $data['subjectScheme'] : null,
            schemeUri: isset($data['schemeUri']) && is_string($data['schemeUri']) ? $data['schemeUri'] : null,
            valueUri: isset($data['valueUri']) && is_string($data['valueUri']) ? $data['valueUri'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
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
