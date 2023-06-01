<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:roles.index|roles.create|roles.edit|roles.delete']);   
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->when(request()->q, function($roles) {
            $roles = $roles->where('name', 'like', '%'. request()->q . '%');
        })->paginate(5);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::latest()->get();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'name' => 'required|unique:roles',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        // Assign permission to role
        $role->syncPermissions($request->input('permissions'));

        if($role)
        {
            // redirect dengan pesan sukes
            return redirect()->route('admin.role.index')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else
        {
            // redirect dengan pesan error
            return redirect()->route('admin.role.index')->with(['error' => 'Data Gagal Tersimpan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::latest()->get();
        return view('admin.roles.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$role->id
        ]);

        $role = Role::findOrFail($role->id);
        $role->update([
            'name' => $request->input('name')
        ]);

        // Assign Permission to role
        $role->syncPermissions($request->input('permissions'));

        if($role)
        {
            // redirect dengan pesan sukes
            return redirect()->route('admin.role.index')->with(['success' => 'Data Berhasil Diupdate']);
        }
        else
        {
            // redirect dengan pesan error
            return redirect()->route('admin.role.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        $role->revokePermissionTo($permissions);
        $role->delete();

        if($role) 
        {
            return response()->json([
                'status' => 'success'
            ]);
        }
        else
        {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
