<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

final readonly class ActivityAttributes
{
    /**
     * @param  array<string, mixed>  $changes  Poorly documented changes object - kept as raw array
     */
    public function __construct(
        public string $provWasGeneratedBy,
        public string $provGeneratedAtTime,
        public string $provWasDerivedFrom,
        public string $provWasAttributedTo,
        public string $action,
        public int $version,
        public array $changes,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['prov:wasGeneratedBy']));
        assert(is_string($data['prov:generatedAtTime']));
        assert(is_string($data['prov:wasDerivedFrom']));
        assert(is_string($data['prov:wasAttributedTo']));
        assert(is_string($data['action']));
        assert(is_numeric($data['version']));
        assert(is_array($data['changes']));

        /** @var array<string, mixed> $changesData */
        $changesData = $data['changes'];

        return new self(
            provWasGeneratedBy: $data['prov:wasGeneratedBy'],
            provGeneratedAtTime: $data['prov:generatedAtTime'],
            provWasDerivedFrom: $data['prov:wasDerivedFrom'],
            provWasAttributedTo: $data['prov:wasAttributedTo'],
            action: $data['action'],
            version: (int) $data['version'],
            changes: $changesData,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'prov:wasGeneratedBy' => $this->provWasGeneratedBy,
            'prov:generatedAtTime' => $this->provGeneratedAtTime,
            'prov:wasDerivedFrom' => $this->provWasDerivedFrom,
            'prov:wasAttributedTo' => $this->provWasAttributedTo,
            'action' => $this->action,
            'version' => $this->version,
            'changes' => $this->changes,
        ];
    }
}
