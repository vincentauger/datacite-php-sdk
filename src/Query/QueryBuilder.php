<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Query;

use VincentAuger\DataCiteSdk\Enums\QueryField;

final class QueryBuilder
{
    /** @var string[] */
    private array $clauses = [];

    /**
     * Add a where clause to the query.
     *
     * @param  QueryField|string  $field  The field to query (QueryField enum or string)
     */
    public function where(QueryField|string $field, string $operator, string $value): self
    {
        $fieldName = $field instanceof QueryField ? $field->value : $field;
        $this->clauses[] = $this->buildClause($fieldName, $operator, $value);

        return $this;
    }

    /**
     * Add an equals clause (field:value).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereEquals(QueryField|string $field, string $value): self
    {
        return $this->where($field, ':', $value);
    }

    /**
     * Add a contains clause (field:*value*).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereContains(QueryField|string $field, string $value): self
    {
        return $this->where($field, ':', "*{$value}*");
    }

    /**
     * Add a starts with clause (field:value*).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereStartsWith(QueryField|string $field, string $value): self
    {
        return $this->where($field, ':', "{$value}*");
    }

    /**
     * Add an ends with clause (field:*value).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereEndsWith(QueryField|string $field, string $value): self
    {
        return $this->where($field, ':', "*{$value}");
    }

    /**
     * Add a where in clause (field:("value1" OR "value2")).
     *
     * @param  QueryField|string  $field  The field to query
     * @param  string[]  $values
     */
    public function whereIn(QueryField|string $field, array $values): self
    {
        $fieldName = $field instanceof QueryField ? $field->value : $field;
        $quotedValues = array_map(fn (string $value): string => "\"{$value}\"", $values);
        $this->clauses[] = "{$fieldName}:(".implode(' OR ', $quotedValues).')';

        return $this;
    }

    /**
     * Add a negated where clause (-field:value).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereNot(QueryField|string $field, string $operator, string $value): self
    {
        $fieldName = $field instanceof QueryField ? $field->value : $field;
        $this->clauses[] = "-{$fieldName}{$operator}{$value}";

        return $this;
    }

    /**
     * Add a negated equals clause (-field:value).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereNotEquals(QueryField|string $field, string $value): self
    {
        return $this->whereNot($field, ':', $value);
    }

    /**
     * Add an AND grouping clause.
     */
    public function whereAnd(callable $callback): self
    {
        $subBuilder = new self;
        $callback($subBuilder);

        if ($subBuilder->clauses !== []) {
            $this->clauses[] = '('.implode(' AND ', $subBuilder->clauses).')';
        }

        return $this;
    }

    /**
     * Add an OR grouping clause.
     */
    public function whereOr(callable $callback): self
    {
        $subBuilder = new self;
        $callback($subBuilder);

        if ($subBuilder->clauses !== []) {
            $this->clauses[] = '('.implode(' OR ', $subBuilder->clauses).')';
        }

        return $this;
    }

    /**
     * Add a where not in clause (multiple -field:value).
     *
     * @param  QueryField|string  $field  The field to query
     * @param  string[]  $values
     */
    public function whereNotIn(QueryField|string $field, array $values): self
    {
        foreach ($values as $value) {
            $this->whereNotEquals($field, $value);
        }

        return $this;
    }

    /**
     * Check if a field exists (field:*).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereExists(QueryField|string $field): self
    {
        return $this->where($field, ':', '*');
    }

    /**
     * Check if a field does not exist (-field:*).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereNotExists(QueryField|string $field): self
    {
        return $this->whereNot($field, ':', '*');
    }

    /**
     * Add an exact match clause (field:"value").
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereExact(QueryField|string $field, string $value): self
    {
        $fieldName = $field instanceof QueryField ? $field->value : $field;
        $this->clauses[] = "{$fieldName}:\"{$value}\"";

        return $this;
    }

    /**
     * Add a wildcard clause (field:pattern).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereWildcard(QueryField|string $field, string $pattern): self
    {
        $fieldName = $field instanceof QueryField ? $field->value : $field;
        $this->clauses[] = "{$fieldName}:{$pattern}";

        return $this;
    }

    /**
     * Add a wildcard exact match clause (escapes spaces).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereWildcardExact(QueryField|string $field, string $value, string $suffix = ''): self
    {
        $fieldName = $field instanceof QueryField ? $field->value : $field;
        // Escape spaces for wildcard + exact match combinations
        $escapedValue = str_replace(' ', '\ ', $value);
        $this->clauses[] = "{$fieldName}:{$escapedValue}{$suffix}";

        return $this;
    }

    /**
     * Add a contains wildcard clause (field:*value*).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereContainsWildcard(QueryField|string $field, string $value): self
    {
        return $this->whereWildcard($field, "*{$value}*");
    }

    /**
     * Add a starts with wildcard clause (field:value*).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereStartsWithWildcard(QueryField|string $field, string $value): self
    {
        return $this->whereWildcard($field, "{$value}*");
    }

    /**
     * Add an ends with wildcard clause (field:*value).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereEndsWithWildcard(QueryField|string $field, string $value): self
    {
        return $this->whereWildcard($field, "*{$value}");
    }

    /**
     * Add a single character wildcard clause (field:pattern with ?).
     *
     * @param  QueryField|string  $field  The field to query
     */
    public function whereSingleCharacterWildcard(QueryField|string $field, string $pattern): self
    {
        return $this->whereWildcard($field, $pattern);
    }

    /**
     * Add a raw query clause.
     */
    public function raw(string $clause): self
    {
        $this->clauses[] = $clause;

        return $this;
    }

    /**
     * Build the final query string.
     */
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
