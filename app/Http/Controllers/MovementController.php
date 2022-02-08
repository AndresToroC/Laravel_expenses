<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Movement;

class MovementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $movements = Movement::whereUserId($user->id)->get();

        return view('movements.index', compact('user', 'movements'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Movement $movement)
    {
        //
    }

    public function edit(Movement $movement)
    {
        //
    }

    public function update(Request $request, Movement $movement)
    {
        //
    }

    public function destroy(Movement $movement)
    {
        //
    }
}
