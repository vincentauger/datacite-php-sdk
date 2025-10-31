<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

use VincentAuger\DataCiteSdk\Enums\EventMessageAction;
use VincentAuger\DataCiteSdk\Enums\EventRelationType;
use VincentAuger\DataCiteSdk\Enums\EventSource;

/**
 * Event attributes.
 *
 * Contains all event metadata including identifiers, source, relations, and timestamps.
 */
final readonly class EventAttributes
{
    public function __construct(
        public string $subjId,
        public string $objId,
        public EventSource $sourceId,
        public EventRelationType $relationTypeId,
        public int $total,
        public EventMessageAction $messageAction,
        public string $sourceToken,
        public string $license,
        public string $occurredAt,
        public string $timestamp,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['subj-id']));
        assert(is_string($data['obj-id']));
        assert(is_string($data['source-id']));
        assert(is_string($data['relation-type-id']));
        assert(is_int($data['total']));
        assert(is_string($data['message-action']));
        assert(is_string($data['source-token']));
        assert(is_string($data['license']));
        assert(is_string($data['occurred-at']));
        assert(is_string($data['timestamp']));

        return new self(
            subjId: $data['subj-id'],
            objId: $data['obj-id'],
            sourceId: EventSource::from($data['source-id']),
            relationTypeId: EventRelationType::from($data['relation-type-id']),
            total: $data['total'],
            messageAction: EventMessageAction::from($data['message-action']),
            sourceToken: $data['source-token'],
            license: $data['license'],
            occurredAt: $data['occurred-at'],
            timestamp: $data['timestamp'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'subj-id' => $this->subjId,
            'obj-id' => $this->objId,
            'source-id' => $this->sourceId->value,
            'relation-type-id' => $this->relationTypeId->value,
            'total' => $this->total,
            'message-action' => $this->messageAction->value,
            'source-token' => $this->sourceToken,
            'license' => $this->license,
            'occurred-at' => $this->occurredAt,
            'timestamp' => $this->timestamp,
        ];
    }
}
