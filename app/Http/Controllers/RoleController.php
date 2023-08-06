<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePermissionRequest;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth('api')->check()){
            $roles = Role::withCount('permissions')->get();
            return response()->json(['roles' => $roles]);
        }
        $roles = Role::withCount('permissions')->get();
        return response()->view('controlPanel.role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('controlPanel.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $validatedData = $request->validated();
        $role = new Role();
        $role->name = $validatedData['name'];
        $role->guard_name = $validatedData['guard'];
        $role->save();
        return response()->json(['message' => 'Create Role Successfuly']);
    }

    public function editRolePermission(Role $role)
    {
        $permissions = Permission::where('guard_name', '=', $role->guard_name)->get();
        $role_permissions = $role->permissions;
        if (count($role_permissions) > 0) {
            foreach ($permissions as $permission) {
                $permission->setAttribute('assigned', false);
                foreach ($role_permissions as $role_permission) {
                    if ($permission->id == $role_permission->id) {
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }

        return response()->view('controlPanel.role.rolePermission', [
            'permissions' => $permissions, 'role' => $role
        ]);
    }

    public function updateRolePermission(RolePermissionRequest $request, Role $role)
    {
        $validatedData = $request->validated();

        $roleId = $validatedData['role_id'];
        $role =  Role::findOrFail($roleId);

        $permissionId = $validatedData['permission_id'];
        $permission = Permission::findOrFail($permissionId);
        // if role has permission revoke يعني اسحبها منها
        // if role not have permission اعطيها الصلاحية

        $role->hasPermissionTo($permission) ?  $role->revokePermissionTo($permission) :  $role->givePermissionTo($permission);
        return response()->json(['message' => 'Permission Updated Successfully']);
        // $permissionId = $validatedData['permission_id'];
        // $permission = Permission::findOrFail($permissionId);

        // if ($role->hasPermissionTo($permission)) {
        //     $role->revokePermissionTo($permission);
        // } else {
        //     $role->givePermissionTo($permission);
        // }

        // return response()->json(['message' => 'Permission Updated Successfully']);
    }




    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return response()->view('controlPanel.role.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $validatedData = $request->validated();
        $role->name = $validatedData['name'];
        $role->guard_name = $validatedData['guard'];
        $role->save();
        return response()->json(['message' => 'Update Role Successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
