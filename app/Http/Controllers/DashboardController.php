<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(){
        return response()->json([
            'users' => User::count(),
            'books' => Book::count()
        ],200);
    }
}
