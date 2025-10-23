<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class FundingReference
{
    public function __construct(
        public string $funderName,
        public ?string $funderIdentifier = null,
        public ?string $funderIdentifierType = null,
        public ?string $awardNumber = null,
        public ?string $awardUri = null,
        public ?string $awardTitle = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            funderName: $data['funderName'],
            funderIdentifier: $data['funderIdentifier'] ?? null,
            funderIdentifierType: $data['funderIdentifierType'] ?? null,
            awardNumber: $data['awardNumber'] ?? null,
            awardUri: $data['awardUri'] ?? null,
            awardTitle: $data['awardTitle'] ?? null,
        );
    }

    public function toArray(): array
    {
        $array = ['funderName' => $this->funderName];

        if ($this->funderIdentifier !== null) {
            $array['funderIdentifier'] = $this->funderIdentifier;
        }

        if ($this->funderIdentifierType !== null) {
            $array['funderIdentifierType'] = $this->funderIdentifierType;
        }

        if ($this->awardNumber !== null) {
            $array['awardNumber'] = $this->awardNumber;
        }

        if ($this->awardUri !== null) {
            $array['awardUri'] = $this->awardUri;
        }

        if ($this->awardTitle !== null) {
            $array['awardTitle'] = $this->awardTitle;
        }

        return $array;
    }
}
