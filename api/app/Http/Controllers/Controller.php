<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use DispatchesJobs, AuthorizesRequests;

    protected $policy;

    public function __construct()
    {
        $this->checkModelPolicy();
        $this->authorizeAction();
    }

    protected function checkModelPolicy()
    {
        if (!$this->policy) {
            return;
        }
    }

    protected function authorizeAction()
    {
        if (!$this->policy) {
            return;
        }

        $method = request()->route()->getActionMethod();
        $ability = $this->normalizeGuessedAbilityName($method);

        if (method_exists($this->policy, $ability)) {
            $this->authorize($method, $this->policy);
        }
    }
}
