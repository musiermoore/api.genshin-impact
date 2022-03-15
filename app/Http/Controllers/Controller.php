<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponses;

    public function getAuthenticatedUser()
    {
        $user = null;

        if (!empty(auth()->user())) {
            $user = \App\Models\User::query()->find(auth()->user()->value('id'));
        }

        return $user;
    }
}
