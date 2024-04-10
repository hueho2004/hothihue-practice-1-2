<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all post",
     *     tags={"Get all post"},
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $post = Post::all();
        return response()->json($post);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
            /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags = {"Create a new post"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="user's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="user's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),

     *     @OA\Response(response="201", description="Successfully"),
     *     @OA\Response(response="400", description="Errors")
     * )
     */
    
    public function store(Request $request)
    {
        $data = $request->all();
        $dataPost = DB::table('posts')->insert(
            [
                'title' => $data['title'],
                'description' => $data['description'] 
            ]
            );
            return response()->json($dataPost,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
            /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a post by ID",
     *     tags={"Post"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *       
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="post not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function show($id)
    {
        $post = DB::table('posts')->where('id',$id)->get();
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
           /**
 * @OA\Put(
 *     path="/api/posts/{id}",
 *     summary="Update a specific post",
 *     tags={"Posts"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Post ID",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="title", type="string"),
 *                 @OA\Property(property="description", type="string")
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Success"),
 *     security={{"bearerAuth":{}}}
 * )
 */
public function update($id, Request $request) {
    $data = $request->all();
    unset($data['id']);
    if (!empty($data)) {
        $affectedRows = DB::table('posts')->where('id', $id)->update($data);
        if ($affectedRows > 0) {
            return response()->json(['message' => 'Posts updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Posts not found or no changes were made'], 404);
        }
    } else {
        return response()->json(['error' => 'No data provided for update'], 400);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
          /**
         * @OA\DELETE(
         *     path="/api/posts/{id}",
         *     tags={"Posts"},
         *     summary="Delete Posts",
         *     description="Delete Posts",
         *     operationId="destroypost",
         *     security={{"bearer":{}}},
         *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
         *     @OA\Response(response=200, description="Posts deleted successfully"),
         *     @OA\Response(response=404, description="Posts not found"),
         * )
         */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json([
            'message' => 'Posts Deleted successfully'
        ]);
    }
}