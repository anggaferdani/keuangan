<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:permission-index')->only('index');
        $this->middleware('permission:permission-create')->only('create');
        $this->middleware('permission:permission-show')->only('show');
        $this->middleware('permission:permission-edit')->only('edit');
        $this->middleware('permission:permission-delete')->only('delete');
    }

    public function index(Request $request){
        $search = $request->input('search');
        $permissions = Permission::where('status', 1);
        if (!empty($search)) {
            $permissions->where('name', 'like', '%' . $search . '%');
        }
        $permissions = $permissions->latest()->paginate(10);
        return view('pages.permission.index', compact(
            'permissions',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $array = [
            'name' => $request['name'],
        ];

        Permission::create($array);

        return redirect()->route('permission.index')->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $permission = Permission::find($id);

        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $array = [
            'name' => $request['name'],
        ];

        $permission->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $permission = Permission::find($id);

        $permission->update([
            'status' => 0,
        ]);

        return redirect()->route('permission.index')->with('success', 'Success');
    }
}
