<?php

namespace App\Http\Controllers\Frontend;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;
use Illuminate\Http\Request;

class FrontendController extends BaseController
{
    public function displayHome(Organization $org, Request $request)
    {

        $current_user = Auth()->user();

        return view('frontend.index')
            ->with('organization', $org)
            ->with('current_user', $current_user)
            ->with('states_list', $this->statesList());
    }
}
