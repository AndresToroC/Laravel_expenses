<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

use App\Helper\UiAvatar;
use App\Models\User;

use App\Exports\SheetExport;
use App\Exports\UserExport;

class UserController extends Controller
{
    function __construct() {
        $this->middleware(['role:admin']);
    }

    public function index(Request $request)
    {
        $searchNameOrEmail = ($request->searchNameOrEmail) ? $request->searchNameOrEmail : '';
        $searchRole = ($request->searchRole) ? $request->searchRole : '';
        $searchStatus = ($request->searchStatusUser) ? $request->searchStatusUser : '';
        
        $users = User::when($searchStatus, function($q) {
                $q->onlyTrashed();
            })->with('roles')
            ->whereHas('roles', function($q) use ($request) {
                if ($request->searchRole) {
                    $q->whereId($request->searchRole);
                }
            })->where(function($q) use ($request) {
                if ($request->searchNameOrEmail) {
                    $q->where('name', 'LIKE', '%'.$request->searchNameOrEmail.'%')
                        ->orWhere('email', 'LIKE', '%'.$request->searchNameOrEmail.'%');
                }
            })->paginate(10);
            
        $roles = Role::select('id AS value', 'name')->get();
        $searchStatusOptions = collect([['value' => 1, 'name' => 'Eliminados']]);

        return view('admin.users.index', compact('users', 'roles', 'searchNameOrEmail', 'searchRole', 'searchStatus', 'searchStatusOptions'));
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

    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->back()->with('message', 'Usuario eliminado correctamente');
    }

    public function restore($userId) {
        $user = User::withTrashed()->whereId($userId)->restore();

        return redirect()->back()->with('message', 'Usuario activado correctamente');
    }

    // Reporte de usuarios
    public function downloadFile() {
        $users = User::with('roles')->select('id', 'name AS Nombre', 'email AS Correo electronico', 'created_at AS Fecha de creacion', 'deleted_at')
            ->withTrashed()->get();

        $array = ['rows' => [], 'title' => ''];

        $header = [];
        $activeUsers = ['rows' => [], 'title' => 'Activos'];
        $eliminatedUsers = ['rows' => [], 'title' => 'Eliminados'];
        foreach ($users as $key => $user) {
            $deleted = $user->deleted_at;
            $rol = ($user->roles[0]->name == 'admin') ? 'Administrador' : 'Cliente';
            $user['Rol'] = $rol;

            unset($user['deleted_at']);
            unset($user['roles']);

            if (count($header) <= 0) {
                $header = array_keys($user->toArray());  
            }

            if ($deleted) {
                $eliminatedUsers['rows'][] = $user->toArray();
                continue;
            }

            $activeUsers['rows'][] = $user->toArray();
        }
        
        $eliminatedUsers['header'] = $header; 
        $activeUsers['header'] = $header; 
        
        return Excel::download(new SheetExport([$activeUsers, $eliminatedUsers]), 'Usuarios.xlsx');
    }
}
