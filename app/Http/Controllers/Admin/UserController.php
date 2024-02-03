<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\helper\helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{

    public $userRepository, $roleRepository;
    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $users  = $this->userRepository->all();
        return view('admin.users.user-index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('create_user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = $this->roleRepository->all();
        return view('admin.users.user-create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        abort_if(Gate::denies('create_user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = $this->userRepository->store($request->all());
        if (count($request->input('roles', [])) > 0) {
            $this->userRepository->assignRole($request->input('roles'), $user);
        }
        return redirect()->route('users.index')->with('success', 'User Create Successfully!');
    }

    public function storeMedia(Request $request)
    {
        $path = public_path('uploads/temp/users/' . Auth::id());
        $file = $request->file('file');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $name = Carbon::now()->format('Ymd') . uniqid() . $file->getClientOriginalName();
        $file->move($path, $name);
        $response =  response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
        return $response;
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('edit_user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = $this->roleRepository->all();
        $user->load('roles');
        return view('admin.users.user-edit', compact('user','roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userRepository->update($request->all(), $user);
        if (count($request->input('roles', [])) > 0) {
            $this->userRepository->assignRole($request->input('roles'), $user);
        }
        return redirect()->route('users.index')->with('success', 'User Update Successfully!');
    }

    public function show()
    {
        dd('hwre');
    }

    public function removeMedia(Request $request)
    {
        $type = $request->type;
        $user_id = $request->model_id;
        $file_name = $request->file_name;
        $model = 'App\Models\User';

        $response = helper::removeMedia($model, $user_id, $type, $file_name);

        return $response;
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('delete_user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->userRepository->softdelete($user);
        return redirect()->back()->with('success', 'User Delete Successfully!');
    }
}
