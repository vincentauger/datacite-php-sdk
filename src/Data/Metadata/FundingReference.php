<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Exceptions\DataCiteValidationException;

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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['funderName']));

        return new self(
            funderName: $data['funderName'],
            funderIdentifier: isset($data['funderIdentifier']) && is_string($data['funderIdentifier']) ? $data['funderIdentifier'] : null,
            funderIdentifierType: isset($data['funderIdentifierType']) && is_string($data['funderIdentifierType']) ? $data['funderIdentifierType'] : null,
            awardNumber: isset($data['awardNumber']) && is_string($data['awardNumber']) ? $data['awardNumber'] : null,
            awardUri: isset($data['awardUri']) && is_string($data['awardUri']) ? $data['awardUri'] : null,
            awardTitle: isset($data['awardTitle']) && is_string($data['awardTitle']) ? $data['awardTitle'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     *
     * @throws DataCiteValidationException If funderIdentifier is provided without funderIdentifierType
     */
    public function toArray(): array
    {
        // Validate conditional dependencies per DataCite Metadata Schema 4.6
        if ($this->funderIdentifier !== null && $this->funderIdentifierType === null) {
            throw new DataCiteValidationException(
                'If funderIdentifier is used, funderIdentifierType is mandatory.'
            );
        }

        if ($this->funderIdentifierType !== null && $this->funderIdentifier === null) {
            throw new DataCiteValidationException(
                'funderIdentifierType cannot be used without funderIdentifier.'
            );
        }

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
