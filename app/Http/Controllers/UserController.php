<?php

namespace App\Http\Controllers;

use App\Helpers\helper\helper;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\Auth;
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
        $roles = $this->roleRepository->all();
        return view('admin.users.user-create', compact('roles'));
    }

    public function store(Request $request)
    {
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
        $roles = $this->roleRepository->all();
        $user->load('roles');
        return view('admin.users.user-edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
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
        $this->userRepository->softdelete($user);
        return redirect()->back()->with('success', 'User Delete Successfully!');
    }
}
