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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['ris']));
        assert(is_string($data['bibtex']));
        assert(is_string($data['citeproc']));
        assert(is_string($data['schemaOrg']));
        assert(is_string($data['resourceTypeGeneral']));

        return new self(
            ris: $data['ris'],
            bibtex: $data['bibtex'],
            citeproc: $data['citeproc'],
            schemaOrg: $data['schemaOrg'],
            resourceType: isset($data['resourceType']) && is_string($data['resourceType']) ? $data['resourceType'] : null,
            resourceTypeGeneral: $data['resourceTypeGeneral'],
        );
    }

    /**
     * @return array<string, mixed>
     */
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
