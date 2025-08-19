<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $category = DB::table('tbl_category_product')
        ->where('category_status', '0')
        ->orderBy('category_id', 'desc')
        ->get();
        
        $brand = DB::table('tbl_brand')
        ->where('brand_status', '0')
        ->orderBy('brand_id', 'desc')
        ->get();

        View::share('category', $category);
        View::share('brand', $brand);
    }
}
