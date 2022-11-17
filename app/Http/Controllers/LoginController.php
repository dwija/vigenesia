<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *      path="/login",
     *      tags={"Login"},
     *      summary="Login",
     *      description="Login",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"email", "password"},
     *            @OA\Property(property="email", type="string", format="string", example="admin@admin.com"),
     *            @OA\Property(property="password", type="string", format="string"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login Berhasil"),
     *             @OA\Property(property="data", type="object",
     *              example={
     *                  "id": 1,
     *	                "nama": "string",
     *	                "profesi": "string",
     *	                "email": "email@email.com",
     *	                "created_at": "string",
     *	                "updated_at": "string"
     *               }
     *             )
     *            )
     *       )
     *  )
     */
    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user == null) {
            return response()->json("Email tidak ditemukan", Response::HTTP_NOT_FOUND);
        }
        if (!Hash::check($password, $user->password)) {
            return response()->json("Ada kesalahan pada email atau password.", Response::HTTP_BAD_REQUEST);
        }
        $response = [
            'message' => 'Login Berhasil',
            'data' => $user
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
