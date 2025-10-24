<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

final readonly class ListLinks
{
    public function __construct(
        public string $self,
        public ?string $next = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['self']));

        return new self(
            self: $data['self'],
            next: isset($data['next']) && is_string($data['next']) ? $data['next'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'self' => $this->self,
        ];

        if ($this->next !== null) {
            $result['next'] = $this->next;
        }

        return $result;
    }
}
