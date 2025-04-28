<?php

namespace App\Traits;

trait HideTimestamps {
    protected function initializeHideTimestamps(): void {
        $fields = ['created_at', 'updated_at', 'deleted_at'];

        $this->hidden = array_merge(
            $this->hidden ?? [],
            $fields
        );
    }
}