<?php

namespace App\Http\Controllers;

use App\Http\Requests\UbahPasswordRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * @OA\Get(
     *      path="/user/{id}",
     *      tags={"User"},
     *      summary="Ambil data profil",
     *      description="Ambil data profil",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="id", type="integer",example=1),
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="profesi", type="string"),
     *             @OA\Property(property="email", type="string", example="email@email.com"),
     *             @OA\Property(property="created_at", type="string"),
     *             @OA\Property(property="updated_at", type="string"),
     *          )
     *       )
     *  )
     */
    public function profil($userId)
    {
        $user = User::where('id', $userId)->first();
        if ($user == null) {
            return response()->json("User tidak ditemukan", Response::HTTP_NOT_FOUND);
        }
        return response()->json($user);
    }

    /**
     * @OA\Post(
     *      path="/user/{id}/ubah-password",
     *      tags={"User"},
     *      summary="Ubah Password",
     *      description="Ubah Password",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"password_lama","password_baru","konfirmasi_password_baru"},
     *            @OA\Property(property="password_lama", type="string", format="string", example="string"),
     *            @OA\Property(property="password_baru", type="string", format="string", example="string"),
     *            @OA\Property(property="konfirmasi_password_baru", type="string", format="string", example="string")
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password berhasil diubah")
     *          )
     *       )
     *  )
     */
    public function ubahPassword(UbahPasswordRequest $request, $userId)
    {
        $user = User::where('id', $userId)->first();
        if ($user == null) {
            return response()->json("User tidak ditemukan", Response::HTTP_NOT_FOUND);
        }
        $passwordLama = $request->password_lama;
        if (!Hash::check($passwordLama, $user->password)) {
            return response()->json("Password Lama tidak valid", Response::HTTP_BAD_REQUEST);
        }
        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);
        return response()->json(['message' => 'Password berhasil diubah']);
    }
}
