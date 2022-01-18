<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

use App\Helper\UiAvatar;
use App\Models\User;

class UserController extends Controller
{
    function __construct() {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::select('id AS value', 'name')->get();
        
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required',
        ];

        if ($request->photo) {
            $rules['photo'] = 'required|image|mimes:jpg,png,jpeg|max:2048';
        }
        
        $request->validate($rules);

        if ($request->photo) {
            $image = $request->photo;

            $avatarUrl = Str::random(40).".".$image->getClientOriginalExtension();
            $image->storeAs('public/', $avatarUrl);
        } else {
            $avatarUrl = UiAvatar::avatar($request->name);
        }
        
        $request['password'] = Hash::make($request->password);
        
        $user = new User($request->except('photo'));
        $user->photo = $avatarUrl;
        $user->save();

        $role = $request->role;
        $user->assignRole($role);

        return redirect()->back()->with('message', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::select('id AS value', 'name')->get();
        $user->load('roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
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

        $user->roles()->detach();

        $role = $request->role;
        $user->assignRole($role);

        return redirect()->back()->with('message', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        //
    }
}
