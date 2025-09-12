<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard-stats', [DashboardController::class, 'stats']);

Route::get('/dashboard-users-by-month', function () {
    $months = [];
    $counts = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $months[] = $date->format('M'); 
        $count = DB::table('users')
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();

        $counts[] = $count;
    }

    return response()->json([
        'labels' => $months,
        'data' => $counts,
    ]);
});

