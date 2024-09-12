<?php

namespace App\Http\Controllers\Api;

use App\Models\Post; // data dari database
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource; // data --> json

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */

     public function index(){
        // get data post
        $post = Post::latest()->paginate(5);

        // return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $post);
     }
}
