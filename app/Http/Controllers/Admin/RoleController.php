<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class RoleController extends Controller
{
    public $roleRepository, $permissionRepository;
    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepository->all();
        return view('admin.roles.role-index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('create role'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = $this->permissionRepository->all();
        return view('admin.roles.roles-create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('create role'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role = $this->roleRepository->store($request->all());
        if(count($request->input('permissions', [])) > 0) {
            $this->roleRepository->assignPermission($request->input('permissions'), $role);
        }
        return redirect()->route('roles.index')->with('success', 'Role Create Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        dd($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        abort_if(Gate::denies('edit role'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = $this->permissionRepository->all();
        $role->load('permissions');
        return view('admin.roles.role-edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        abort_if(Gate::denies('edit role'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->roleRepository->update($request->all(), $role);
        if(count($request->input('permissions', [])) > 0) {
            $this->roleRepository->assignPermission($request->input('permissions'), $role);
        }
        return redirect()->route('roles.index')->with('success', 'Role Update Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        abort_if(Gate::denies('delete role'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->roleRepository->softdelete($role);
        return redirect()->back()->with('success', 'Role Delete Successfully!');
    }
}
