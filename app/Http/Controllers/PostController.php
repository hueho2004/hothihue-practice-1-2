<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostController extends Controller
{
    private $posts;
    public function __construct()
    {
        $this->posts = new Post();
    }
    public function index(){
        $postList = $this->posts->getAllPost();
        // dd($postList);
        return  $postList;
    }
    public function store(Request $request){
        $data = $request->all();
        $addPost = DB::table('posts')->insert($data);
        return $addPost;
    }
    public function show($id){
        $getPost=DB::table('posts')->where('id',$id)->get();
        return $getPost;
    }
    public function update($id, Request $request) {
        $data = $request->all();
        $updatePost = DB::table('posts')->where('id', $id)->update($data);
        return $updatePost;
    }
    public function destroy($id){
        $destroyPost= DB::table('posts')->where('id', $id)->delete();
        return $destroyPost;
    }
}