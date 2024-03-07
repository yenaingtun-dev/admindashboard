<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
      public function all(): Collection
      {
            return Post::all();
      }

      public function find($id)
      {
            return Post::find($id);
      }

      public function store($data)
      {
           return Post::create($data);
      }

      public function update($data, $id)
      {
            $post = Post::find($id);
            if ($post) {
                  return $post->update($data);
            }
      }

      public function softDelete($post)
      {
            $post->delete();
      }

      public function forceDelete($post)
      {
            $post->forceDelete();
      }

      public function restore($id)
      {
            $this->all()->withTrashed()->find($id)->restore();
      }

      public function restoreAll()
      {
            $this->all()->onlyTrashed()->restore();
      }
}
