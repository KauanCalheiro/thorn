<?php

namespace App\Traits;

use App\Contracts\JoinableContract;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\Models\Relation;

trait Joinable {
    final public function scopeApplyJoins(Builder $query): Builder {
        if ($this instanceof JoinableContract) {
            return $this->resolveJoins($query, $this->getJoinRelations());
        }

        throw new \Exception('Model must implement JoinableContract');
    }

    /**
     * @param  Builder $query
     * @param  Relation[]  $relations
     *
     * @return Builder
     *
     * @author Kauan Morinel Calheiro <kauan.calheiro@univates.br>
     *
     * @date 2025-01-23
     */
    final public function resolveJoins(Builder $query, array $relations): Builder {
        if (empty($relations)) {
            return $query;
        }

        foreach ($relations as $relation) {
            $relatedTable = $relation->getQualifiedRelatedTableName();
            $foreignKey = $relation->getQualifiedRelatedKeyName();
            $localKey = $relation->getQualifiedParentKeyName($this->getTable());

            if (!collect($query->getQuery()->joins)->pluck('table')->contains($relatedTable)) {
                $query->join($relatedTable, $foreignKey, '=', $localKey);
            }
        }

        $this->resolveSelectColumns($query);

        return $query;
    }

    private function resolveSelectColumns(Builder $query) {
        if (empty($query->getQuery()->columns)) {
            $columns = array_map(function ($column) {
                return "{$this->getTable()}.{$column}";
            }, array_diff($this->getFillable(), $this->getHidden()));

            array_unshift($columns, "{$this->getTable()}.id");

            $query->select($columns);
        }
    }
}

