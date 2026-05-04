<?php

namespace DMO\SavingsBond\Controllers\Dashboard;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function displayDashboard(Organization $org, Request $request)
    {

        $current_user = Auth()->user();

        return view('dmo-savings-bond-module::dashboard.index')
            ->with('organization', $org);
    }
}
