<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Helper\DashboardGeneral;

use App\Models\User;

class DashboardController extends Controller
{
    public function general(Request $request) {
        $user = User::whereId(Auth::user()->id)->role('admin')->first();

        if (!$user) {
            abort(403);
        }

        $month = $request->month;
        if (!$month) {
            $month = Carbon::now()->isoFormat('YYYY-MM');
        }

        $dashboard = new DashboardGeneral($month);
        $users = $dashboard->users();
        $countCategories = $dashboard->countCategories();
        $movementsForDays = $dashboard->movementsForDays();
        $userMovements = $dashboard->userMovements();
        
        $data = compact('month', 'users', 'countCategories', 'movementsForDays', 'userMovements');
        
        return view('dashboard.general', $data);
    }

    public function personal() {
        return view('dashboard.personal');
    }
}
