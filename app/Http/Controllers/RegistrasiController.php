<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrasiRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    /**
     * @OA\Post(
     *      path="/registrasi",
     *      tags={"Registrasi"},
     *      summary="Registrasi",
     *      description="Registrasi",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"nama", "profesi","email","password","konfirmasi_password"},
     *            @OA\Property(property="nama", type="string", format="string", example="string"),
     *            @OA\Property(property="profesi", type="string", format="string", example="string"),
     *            @OA\Property(property="email", type="string", format="string", example="admin@admin.com"),
     *            @OA\Property(property="password", type="string", format="string", example="string"),
     *            @OA\Property(property="konfirmasi_password", type="string", format="string", example="string"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Registrasi Berhasil"),
     *             @OA\Property(property="data",type="object",
     *                  example={
     *                      "id": 1,
     *	                    "nama": "string",
     *	                    "profesi": "string",
     *	                    "email": "email@email.com",
     *	                    "created_at": "string",
     *	                    "updated_at": "string"
     *                  }
     *             )
     *          )
     *       )
     *  )
     */
    public function registrasi(RegistrasiRequest $request)
    {
        $user = User::create([
            'nama' => $request->nama,
            'profesi' => $request->profesi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $response = [
            'message' => 'Registrasi Berhasil',
            'data' => $user
        ];
        return response()->json($response);
    }
}
