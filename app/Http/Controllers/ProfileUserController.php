<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Helper\UiAvatar;
use App\Models\User;

class ProfileUserController extends Controller
{
    public function show($userId)
    {
        $user = User::with('roles', 'socialiteProfiles')->whereId($userId)->first();

        return view('profile.show', compact('user'));
    }

    public function update(Request $request, $userId)
    {
        $user = User::whereId($userId)->first();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,id,'.$user->id
        ];

        if ($request->photo) {
            $rules['photo'] = 'required|image|mimes:jpg,png,jpeg|max:2048';
        }
        
        if ($request->password) {
            $rules['password'] = 'required|confirmed';
            $request->validate($rules);

            $request['password'] = Hash::make($request->password);
        } else {
            unset($request['password']);

            $request->validate($rules);
        }

        $avatarUrl = '';
        if ($request->photo) {
            $image = $request->photo;
            
            $avatarUrl = Str::random(40).".".$image->getClientOriginalExtension();
            $image->storeAs('public/', $avatarUrl);

            // Eliminar la foto que tenia antes el usuario
            Storage::delete('public/'.$user->photo);
        } else {
            if (!$user->photo) {
                $avatarUrl = UiAvatar::avatar($request->name);
            }
        }

        $user->update($request->except('photo'));

        if ($avatarUrl) {
            $user->update(['photo' => $avatarUrl]);
        }

        return redirect()->back()->with('message', 'Usuario actualizado correctamente');
    }
}
