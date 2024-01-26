<?php

namespace App\Helpers;

use File;

class helper
{
      static public function moveImage($fileName, $path, $type, $model)
      {
            try {
                  $newPath = '';
                  $imagePath = '';
                  if ($fileName) {
                        if ($model === 'users') {
                              $oldPath = 'uploads/temp/' . $model . '/' . Auth::id() . '/' . $fileName;
                        } else {
                              $oldPath = 'uploads/temp/' . $model .  '/' . $fileName;
                        }
                        $newPath = public_path($path . $type);
                        if (!File::isDirectory($newPath)) {
                              File::makeDirectory($newPath, 0777, true, true);
                        }

                        // Move the file to the destination directory
                        File::copy($oldPath, $newPath . '/' . $fileName);
                        if (File::exists($oldPath)) {
                              File::delete($oldPath);
                        }
                        $imagePath = '/' . $path . $type . '/' . $fileName;
                  }
                  return $imagePath;
            } catch (Exception $e) {
                  return redirect()->back()->with('error', $e->getMessage());
            }
      }

      static public function getImageSrc($path)
      {
          $src = '/default_image.png';
          if ($path && str_contains($path, '/')) {
              if (file_exists(explode('/', $path, 2)[1])) {
                  $src = $path;
              }
          }
          return $src;
      }

      static public function getImageName($fileName)
      {
         $array  = explode('/', $fileName);
         return $array[count($array) - 1];
      }
}