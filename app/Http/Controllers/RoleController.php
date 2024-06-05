<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:role-index')->only('index');
        $this->middleware('permission:role-create')->only('create');
        $this->middleware('permission:role-show')->only('show');
        $this->middleware('permission:role-edit')->only('edit');
        $this->middleware('permission:role-delete')->only('delete');
    }

    public function index(Request $request){
        $search = $request->input('search');
        $roles = Role::where('status', 1);
        if (!empty($search)) {
            $roles->where('name', 'like', '%' . $search . '%');
        }
        $roles = $roles->latest()->paginate(10);
        $permissions = Permission::where('status', 1)->get();
        return view('pages.role.index', compact(
            'roles',
            'permissions',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);

        $array = [
            'name' => $request['name'],
        ];

        $role = Role::create($array);

        $role->permissions()->attach($request['permissions']);

        return redirect()->route('role.index')->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $role = Role::find($id);

        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);

        $array = [
            'name' => $request['name'],
        ];

        $role->update($array);

        $role->permissions()->sync($request['permissions']);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $role = Role::find($id);

        $role->update([
            'status' => 0,
        ]);

        return redirect()->route('role.index')->with('success', 'Success');
    }
}
