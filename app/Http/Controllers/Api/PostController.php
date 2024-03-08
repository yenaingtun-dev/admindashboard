<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Responses\ResponseFormat;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use ResponseFormat;
    public $postRepository;
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->all();
        if (!$posts->isEmpty()) {
            return $this->apiSuccessResponse($posts, 'getting all posts');
        } else {
            return $this->apiErrorResponse($posts,'there is no posts!');
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->apiErrorResponse('Validation Error.', $validator->errors());       
        }
        $post = $this->postRepository->store($request->all());
        return $this->apiSuccessResponse($post, 'successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postRepository->find($id);
        if (is_null($post)) {
            return $this->apiErrorResponse($post,'there is no post!');
        } 
        return $this->apiSuccessResponse($post, 'Post found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->apiErrorResponse('Validation Error.', $validator->errors());       
        }
        $post = $this->postRepository->update($request->all(), $id);
        if (is_null($post)) {
            return $this->apiErrorResponse($post,'there is no post!');
        }
        return $this->apiSuccessResponse($post, 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->postRepository->find($id);
        if (is_null($post)) {
            return $this->apiErrorResponse($post,'there is no post!');
        }
        $this->postRepository->softDelete($post);
        return $this->apiSuccessResponse($post, 'Post Deleted');
    }
}
