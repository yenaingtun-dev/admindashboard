<?php

namespace App\Repositories;

use File;
use Exception;
use App\Models\User;
use App\Helpers\helper\helper;
use Illuminate\Support\Facades\DB;
use function App\Helpers\MoveImage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
      public function all(): Collection
      {
            return User::all();
      }

      public function find($id)
      {
            return $this->all()->find($id);
      }

      public function store($data)
      {
            $user = User::create($data);
            $newPath = '';
            $imagePath = '';
            if(isset($data['profile_image_path'])) 
            {
                  if ($data['profile_image_path']) {
                        $oldPath = 'uploads/temp/' . 'users' . '/' . Auth::id() . '/' . $data['profile_image_path'];
                  }
                  $newPath = public_path(User::IMAGE_PATH . 'profileImagePath');
                  if (!File::isDirectory($newPath)) {
                        File::makeDirectory($newPath, 0777, true, true);
                  }
                  File::copy($oldPath, $newPath . '/' . $data['profile_image_path']);
                  if (File::exists($oldPath)) {
                        File::delete($oldPath);
                  }
                  $imagePath = '/' . User::IMAGE_PATH . 'profileImagePath' . '/' . $data['profile_image_path'];
                  $user->profile_image_path = $imagePath;
                  $user->save();
                  File::deleteDirectory(public_path('uploads/temp/users/' . Auth::id()));
            }
            return $user;
      }

      public function update($data, $user)
      {
            if (!empty($data['profile_image_path'])) {
                  $profile_image = $data['profile_image_path'];
                  unset($data['profile_image_path']);
            }
            $user->update($data);
            if (!empty($profile_image) && empty($user->profile_image_path)) {
                  $imagePath =  helper::moveImage($profile_image, User::IMAGE_PATH, 'profileImagePath', 'users');
                  if (File::exists($user->profile_image_path)) {
                        File::delete($user->profile_image_path);
                  }
                  $user->profile_image_path = $imagePath;
                  $user->save();
            }
            File::deleteDirectory(public_path('uploads/temp/users/' . Auth::id()));
            return $user;
      }

      public function softDelete($user)
      {
            $user->delete();
      }

      public function forceDelete($user)
      {
            $user->forceDelete();
      }

      public function restore($id)
      {
            $this->all()->withTrashed()->find($id)->restore();
      }

      public function restoreAll()
      {
            $this->all()->onlyTrashed()->restore();
      }

      public function assignRole($roleInputs, $user)
      {
            $roles = [];
            if (count($roleInputs) > 0) {
                  foreach ($roleInputs as $key => $value) {
                        array_push($roles, $value);
                  }
            }
            $user->roles()->sync($roles);
      }
}
