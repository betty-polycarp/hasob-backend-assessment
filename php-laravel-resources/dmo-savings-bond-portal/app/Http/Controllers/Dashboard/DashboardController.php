<?php

namespace App\Http\Controllers\Dashboard;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index(Organization $org, Request $request)
    {

        $current_user = Auth()->user();
        $assignments = [];

        return view('dashboard.index')
            ->with('organization', $org)
            ->with('assignments', $assignments)
            ->with('current_user', $current_user);
    }
}
