<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface JoinableContract {

    /**
     * @param  Builder $query
     *
     * @return \App\Helpers\Models\Relation[]
     *
     * @author Kauan Morinel Calheiro <kauan.calheiro@univates.br>
     *
     * @date 2025-01-23
     */
    public function getJoinRelations(): array;

    /**
     * Undocumented function
     *
     * @param  Builder $query
     * @param  \App\Helpers\Models\Relation[]  $relations
     *
     * @return Builder
     *
     * @author Kauan Morinel Calheiro <kauan.calheiro@univates.br>
     *
     * @date 2025-01-23
     */
    public function resolveJoins(Builder $query, array $relations): Builder ;

    public function scopeApplyJoins(Builder $query): Builder;
}
