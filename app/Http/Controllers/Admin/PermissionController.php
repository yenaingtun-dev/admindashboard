<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionController extends Controller
{

    public $permissionRepository;
    public function __construct(PermissionRepositoryInterface $permissionRepository) {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->permissionRepository->all();
        return view('admin.permissions.permission-index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('create_permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.permissions.permission-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->permissionRepository->store($request->all());
        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        dd($permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('edit_permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.permissions.permission-edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        abort_if(Gate::denies('edit_permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->permissionRepository->update($request->all(), $permission);
        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('delete_permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->permissionRepository->softDelete($permission);
        return back();
    }
}
