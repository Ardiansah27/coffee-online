<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Tambahkan ini
use App\Models\Order; // Tambahkan ini agar model Order terbaca

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
        // Bagikan variabel pendingOrdersCount ke semua view
        View::composer('*', function ($view) {
            // Cek apakah user sudah login dan apakah dia admin
            if (auth()->check() && auth()->user()->role == 'admin') {
                $count = Order::where('status', 'pending')->count();
                $view->with('pendingOrdersCount', $count);
            } else {
                // Jika bukan admin atau belum login, set jadi 0 agar tidak error
                $view->with('pendingOrdersCount', 0);
            }
        });
    }
}