<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Query;

final class QueryBuilder
{
    /** @var string[] */
    private array $clauses = [];

    public function where(string $field, string $operator, string $value): self
    {
        $this->clauses[] = $this->buildClause($field, $operator, $value);

        return $this;
    }

    public function whereEquals(string $field, string $value): self
    {
        return $this->where($field, ':', $value);
    }

    public function whereContains(string $field, string $value): self
    {
        return $this->where($field, ':', "*{$value}*");
    }

    public function whereStartsWith(string $field, string $value): self
    {
        return $this->where($field, ':', "{$value}*");
    }

    public function whereEndsWith(string $field, string $value): self
    {
        return $this->where($field, ':', "*{$value}");
    }

    /** @param string[] $values */
    public function whereIn(string $field, array $values): self
    {
        $quotedValues = array_map(fn (string $value): string => "\"{$value}\"", $values);
        $this->clauses[] = "{$field}:(".implode(' OR ', $quotedValues).')';

        return $this;
    }

    public function whereNot(string $field, string $operator, string $value): self
    {
        $this->clauses[] = "-{$field}{$operator}{$value}";

        return $this;
    }

    public function whereNotEquals(string $field, string $value): self
    {
        return $this->whereNot($field, ':', $value);
    }

    public function whereAnd(callable $callback): self
    {
        $subBuilder = new self;
        $callback($subBuilder);

        if ($subBuilder->clauses !== []) {
            $this->clauses[] = '('.implode(' AND ', $subBuilder->clauses).')';
        }

        return $this;
    }

    public function whereOr(callable $callback): self
    {
        $subBuilder = new self;
        $callback($subBuilder);

        if ($subBuilder->clauses !== []) {
            $this->clauses[] = '('.implode(' OR ', $subBuilder->clauses).')';
        }

        return $this;
    }

    /** @param string[] $values */
    public function whereNotIn(string $field, array $values): self
    {
        foreach ($values as $value) {
            $this->whereNotEquals($field, $value);
        }

        return $this;
    }

    public function whereExists(string $field): self
    {
        return $this->where($field, ':', '*');
    }

    public function whereNotExists(string $field): self
    {
        return $this->whereNot($field, ':', '*');
    }

    public function whereExact(string $field, string $value): self
    {
        $this->clauses[] = "{$field}:\"{$value}\"";

        return $this;
    }

    public function raw(string $clause): self
    {
        $this->clauses[] = $clause;

        return $this;
    }

    public function build(): string
    {
        return implode(' ', $this->clauses);
    }

    private function buildClause(string $field, string $operator, string $value): string
    {
        if (str_contains($value, ' ')) {
            $value = "\"{$value}\"";
        }

        return "{$field}{$operator}{$value}";
    }
}
