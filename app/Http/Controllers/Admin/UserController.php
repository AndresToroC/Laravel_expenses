<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $role = Role::whereName('client')->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $avatarUrl = UiAvatar::avatar($request->name);
        
        $request['password'] = Hash::make($request->password);
        $request['photo'] = $avatarUrl;

        $user = User::create($request->all());

        $user->assignRole($role);

        return redirect()->back()->with('message', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $role = Role::whereName('client')->first();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,id,'.$user->id
        ];
        
        if ($request->password) {
            $rules['password'] = 'required|confirmed';
            $request->validate($rules);

            $request['password'] = Hash::make($request->password);
        } else {
            unset($request['password']);

            $request->validate($rules);
        }

        if (!$user->photo) {
            $avatarUrl = UiAvatar::avatar($request->name);
            $request['photo'] = $avatarUrl;
        }

        $user->update($request->all());

        $user->roles()->detach();
        $user->assignRole($role);

        return redirect()->back()->with('message', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
