<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Cashier\User;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(User::class);
        Cashier::calculateTaxes();
        Paginator::defaultView('vendor.pagination.bootstrap-5');  
        // إذا كنت تستخدم ملف الترقيم الذي قمت بإنشائه
     

    }
}
