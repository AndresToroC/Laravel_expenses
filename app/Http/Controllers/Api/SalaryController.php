<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class SalaryController extends Controller
{
    // Actualizar salario
    public function salary(Request $request, User $user) {
        $salary = $request->salary ? $request->salary : 0;
        
        $user->update(['salary' => $salary]);

        return response()->json([
            'message' => 'Salario actualizado correctamente'
        ], 200);
    }
}
