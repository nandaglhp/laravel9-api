<?php

namespace App\Http\Controllers\Api;

use App\Models\Post; // data dari database
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource; // data --> json
use Illuminate\Support\Facades\Validator;

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

     /**
      * store
      * @param mixed $request
      * @return void
      */

      public function store(Request $request){
        // define validation rules
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        // check if validation fails
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        $post = Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content' => $request->content,
        ]);

        // Debugging output
        if (!$post) {
            return response()->json(['message' => 'Failed to create post'], 500);
        }

        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
      }

      /**
       * show
       *
       * @param mixed $post
       * @return void
       */

    //    model/dependency injection
      public function show(Post $post){
        // return single post as a resource
        return new PostResource(true, 'Data Post Ditemukan!', $post);
      }
}
