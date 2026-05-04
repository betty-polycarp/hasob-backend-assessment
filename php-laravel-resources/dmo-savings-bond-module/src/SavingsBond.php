<?php

namespace DMO\SavingsBond;

use DMO\SavingsBond\Controllers\API\BidAPIController;
use DMO\SavingsBond\Controllers\API\BrokerAPIController;
use DMO\SavingsBond\Controllers\API\BrokerStaffAPIController;
use DMO\SavingsBond\Controllers\API\InvestorAPIController;
use DMO\SavingsBond\Controllers\API\OfferAPIController;
use DMO\SavingsBond\Controllers\API\SubscriptionAPIController;
use DMO\SavingsBond\Controllers\Dashboard\DashboardController;
use DMO\SavingsBond\Controllers\Models\BidController;
use DMO\SavingsBond\Controllers\Models\BrokerController;
use DMO\SavingsBond\Controllers\Models\BrokerStaffController;
use DMO\SavingsBond\Controllers\Models\InvestorController;
use DMO\SavingsBond\Controllers\Models\OfferController;
use DMO\SavingsBond\Controllers\Models\SubscriptionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class SavingsBond
{
    public function get_menu_map()
    {

        $current_user = Auth::user();
        if ($current_user != null) {

            $organization = $current_user->organization;
            if (\FoundationCore::has_feature('savings-bond', $organization)) {

                $fc_menu = [];

                if ($current_user->hasAnyRole(['admin', 'dmo-admin'])) {
                    $fc_menu['mnu_sb_dashboard'] = [
                        'id' => 'mnu_sb_dashboard',
                        'label' => 'SavingsBond',
                        'icon' => 'bx bx-unite',
                        'path' => route('sb.dashboard'),
                        'route-selector' => 'sb/dashboard*',
                        'is-parent' => true,
                        'children' => [],
                    ];
                }

                if ($current_user->hasAnyRole(['admin', 'dmo-admin'])) {
                    $fc_menu['mnu_sb_admin'] = [
                        'id' => 'mnu_sb_admin',
                        'label' => 'SavingsBond Admin',
                        'icon' => 'bx bx-grid-alt',
                        'path' => '#',
                        'route-selector' => 'sb/results*',
                        'is-parent' => true,
                        'children' => [

                            'mnu_sb_bond_offers' => [
                                'id' => 'mnu_sb_bond_offers',
                                'label' => 'Bond Offers',
                                'icon' => 'bx bx-right-arrow-alt',
                                'path' => route('sb.offers.index'),
                                'route-selector' => 'sb/offers*',
                                'is-parent' => false,
                                'children' => [],
                            ],
                            'mnu_sb_investors' => [
                                'id' => 'mnu_sb_investors',
                                'label' => 'Investors',
                                'icon' => 'bx bx-right-arrow-alt',
                                'path' => route('sb.investors.index'),
                                'route-selector' => 'sb/investors*',
                                'is-parent' => false,
                                'children' => [],
                            ],
                            'mnu_sb_brokers' => [
                                'id' => 'mnu_sb_brokers',
                                'label' => 'Brokers',
                                'icon' => 'bx bx-right-arrow-alt',
                                'path' => route('sb.brokers.index'),
                                'route-selector' => 'sb/brokers*',
                                'is-parent' => false,
                                'children' => [],
                            ],
                            'mnu_sb_subscriptions' => [
                                'id' => 'mnu_sb_subscriptions',
                                'label' => 'Subscriptions',
                                'icon' => 'bx bx-right-arrow-alt',
                                'path' => route('sb.subscriptions.index'),
                                'route-selector' => 'sb/subscriptions*',
                                'is-parent' => false,
                                'children' => [],
                            ],
                        ],
                    ];
                }

                return $fc_menu;
            }
        }

        return [];
    }

    public function api_routes()
    {

        Route::name('sb-api.')->prefix('sb-api')->group(function () {
            Route::resource('offers', OfferAPIController::class);
            Route::resource('brokers', BrokerAPIController::class);
            Route::resource('broker_staffs', BrokerStaffAPIController::class);
            Route::resource('investors', InvestorAPIController::class);
            Route::resource('bids', BidAPIController::class);
            Route::resource('subscriptions', SubscriptionAPIController::class);
        });
    }

    public function api_public_routes() {}

    public function public_routes() {}

    public function routes()
    {

        Route::name('sb.')->prefix('sb')->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'displayDashboard'])->name('dashboard');

            Route::resource('offers', OfferController::class);
            Route::resource('brokers', BrokerController::class);
            Route::resource('brokerStaffs', BrokerStaffController::class);
            Route::resource('investors', InvestorController::class);
            Route::resource('bids', BidController::class);
            Route::resource('subscriptions', SubscriptionController::class);

        });

    }
}
