<?php

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogsAll
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logAll();
    }
}
