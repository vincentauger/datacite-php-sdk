<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class TypeData
{
    public function __construct(
        public string $ris,
        public string $bibtex,
        public string $citeproc,
        public string $schemaOrg,
        public ?string $resourceType,
        public string $resourceTypeGeneral,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            ris: $data['ris'],
            bibtex: $data['bibtex'],
            citeproc: $data['citeproc'],
            schemaOrg: $data['schemaOrg'],
            resourceType: $data['resourceType'] ?? null,
            resourceTypeGeneral: $data['resourceTypeGeneral'],
        );
    }

    public function toArray(): array
    {
        $array = [
            'ris' => $this->ris,
            'bibtex' => $this->bibtex,
            'citeproc' => $this->citeproc,
            'schemaOrg' => $this->schemaOrg,
            'resourceTypeGeneral' => $this->resourceTypeGeneral,
        ];

        if ($this->resourceType !== null) {
            $array['resourceType'] = $this->resourceType;
        }

        return $array;
    }
}
