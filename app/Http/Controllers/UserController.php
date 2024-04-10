<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="Documentation for the API"
 * )
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"Get all users"},
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $users= User::all();
        return response()->json($users);
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
     *     path="/api/users",
     *     summary="Create a new user",
     *     tags = {"Create a new user"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="user's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="user's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *    @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="user's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Successfully"),
     *     @OA\Response(response="400", description="Errors")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:15',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
        ], [
            'name.required' => 'Họ và tên bắt buộc phải nhập',
            'name.string' => 'Họ và tên bắt buộc là string',
            'name.min' => 'Họ và tên phải từ :min ký tự trở lên',
            'name.max' => 'Họ và tên phải nhỏ hơn :max ký tự',
            'email.required' => 'Email bắt buộc phải nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trên hệ thống',
            'email.string' => 'Email bắt buộc là string',
            'password.required' => 'Password bắt buộc phải nhập',
            'password.string' => 'Password bắt buộc là string',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json($errors, 412);
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ];
            DB::table('users')->insert($data);
            if ($request->number) {
                $user = User::where('email', $request->email)->first();
                $phone = $user->posts()->create([
                    'title' => $request->title,
                ]);
            }
            if ($user) {
                return response()->json('Thành công', 200);
            } else {
                return response()->json('Thất bại', 400);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get a user by ID",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to retrieve",
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
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function show($id){
        $getPost=DB::table('users')->where('id',$id)->get();
        return $getPost;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
 *     path="/api/users/{id}",
 *     summary="Update a specific user",
 *     tags={"Posts"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="name", type="string"),
 *                 @OA\Property(property="email", type="string"),
 *                  @OA\Property(property="password", type="string"),
 *                  @OA\Property(property="number", type="string")
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
        $affectedRows = DB::table('users')->where('id', $id)->update($data);
        if ($affectedRows > 0) {
            return response()->json(['message' => 'User updated successfully'], 200);
        } else {
            return response()->json(['error' => 'User not found or no changes were made'], 404);
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
         *     path="/api/users/{id}",
         *     tags={"User"},
         *     summary="Delete User",
         *     description="Delete User",
         *     operationId="destroy",
         *     security={{"bearer":{}}},
         *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
         *     @OA\Response(response=200, description="User deleted successfully"),
         *     @OA\Response(response=404, description="User not found"),
         * )
         */
        public function destroy($id)
        {
            $user = User::findOrFail($id);

            $user->delete();

            return response()->json(['message' => 'User deleted successfully']);
        }

}