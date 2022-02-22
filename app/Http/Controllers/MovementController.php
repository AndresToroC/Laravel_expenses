<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Movement;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ? $request->date : '';
        
        $user = Auth::user();
        $movements = [];

        if ($date) {
            $movements = Movement::with('sub_category.categories')
                ->whereUserId($user->id)->where('date', 'LIKE', $date.'%')->paginate(10);
        }

        return view('movements.index', compact('user', 'movements', 'date'));
    }

    public function create(Request $request)
    {
        $date = $request->date ? $request->date : '';
        
        return view('movements.create', compact('date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'description' => 'required|max:255',
            'value' => 'required',
            'date' => 'required'
        ]);

        $user = Auth::user();

        $request['user_id'] = $user->id;
        $request['date'] = $request->date;
        unset($request['category_id']);

        Movement::create($request->all());

        return redirect()->back()->with(['message' => 'Movimiento creado correctamente']);
    }

    public function show(Movement $movement)
    {
        //
    }

    public function edit(Request $request, Movement $movement)
    {
        $date = $request->date ? $request->date : '';
        $movement->load('sub_category');

        return view('movements.edit', compact('movement', 'date'));
    }

    public function update(Request $request, Movement $movement)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'description' => 'required|max:255',
            'value' => 'required',
            'date' => 'required'
        ]);

        unset($request['category_id']);

        $movement->update($request->all());

        return redirect()->back()->with(['message' => 'Movimiento actualizado correctamente']);
    }

    public function destroy(Movement $movement)
    {
        $movement->delete();

        return redirect()->back()->with(['message' => 'Movimiento eliminado correctamente']);
    }
}
