<?php

namespace App\Http\Controllers;

use App\Helpers\helper\helper;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{

    public $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users  = $this->userRepository->all();
        return view('admin.users.user-index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.user-create');
    }

    public function store(Request $request)
    {
        $this->userRepository->store($request->all());
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
        return view('admin.users.user-edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->userRepository->update($request->all(), $user);

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
}
