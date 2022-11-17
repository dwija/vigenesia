<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotivasiRequest;
use App\Models\Motivasi;
use App\Models\User;
use Illuminate\Http\Response;

class MotivasiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/user/{userId}/motivasi",
     *      tags={"Motivasi"},
     *      summary="Ambil data motivasi",
     *      description="Ambil data motivasi",
     *      @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                  ),
     *                  @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         example=1
     *                  ),
     *                  @OA\Property(
     *                         property="isi_motivasi",
     *                         type="string",
     *                         example="string"
     *                  ),
     *                  @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="string"
     *                  ),
     *                  @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="string"
     *                  ),
     *              )
     *             )
     *          )
     *       )
     *  )
     */
    public function getAll($userId)
    {
        $this->findUser($userId);
        $motivasi = Motivasi::where('user_id', $userId)->orderBy('id', 'desc')->get();
        return response()->json(['data' => $motivasi]);
    }

    /**
     * @OA\Post(
     *      path="/user/{userId}/motivasi",
     *      tags={"Motivasi"},
     *      summary="Simpan data motivasi",
     *      description="Simpan data motivasi",
     *      @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"isi_motivasi"},
     *            @OA\Property(property="isi_motivasi", type="string", format="string", example="string")
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Motivasi berhasil tersimpan"),
     *             @OA\Property(property="data",type="object",
     *                  example={
     *                      "id": 1,
     *	                    "user_id": "string",
     *	                    "isi_motivasi": "string",
     *	                    "created_at": "string",
     *	                    "updated_at": "string"
     *                  }
     *             )
     *          )
     *       )
     *  )
     */
    public function create(MotivasiRequest $request, $userId)
    {
        $this->findUser($userId);
        $motivasi = Motivasi::create([
            'isi_motivasi' => $request->isi_motivasi,
            'user_id' => $userId,
        ]);
        $response = [
            'message' => 'Motivasi berhasil tersimpan',
            'data' => $motivasi
        ];
        return response()->json($response);
    }

    /**
     * @OA\Put(
     *      path="/user/{userId}/motivasi/{id}",
     *      tags={"Motivasi"},
     *      summary="Ubah data motivasi",
     *      description="Ubah data motivasi",
     *      @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Motivasi ID",
     *         required=true,
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"isi_motivasi"},
     *            @OA\Property(property="isi_motivasi", type="string", format="string", example="string")
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Motivasi berhasil diubah"),
     *             @OA\Property(property="data",type="boolean")
     *          )
     *       )
     *  )
     */
    public function update(MotivasiRequest $request, $userId, $id)
    {
        $this->findUser($userId);
        $motivasi = $this->findMotivasi($userId, $id);
        if ($motivasi == null) {
            return response()->json("Motivasi tidak ditemukan", Response::HTTP_NOT_FOUND);
        }
        $result = $motivasi->update([
            'isi_motivasi' => $request->isi_motivasi
        ]);
        $response = [
            'message' => 'Motivasi berhasil diubah',
            'data' => $result
        ];
        return response()->json($response);
    }

    /**
     * @OA\Delete(
     *      path="/user/{userId}/motivasi/{id}",
     *      tags={"Motivasi"},
     *      summary="Hapus data motivasi",
     *      description="Hapus data motivasi",
     *      @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Motivasi ID",
     *         required=true,
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Motivasi berhasil dihapus"),
     *             @OA\Property(property="data",type="boolean")
     *          )
     *       )
     *  )
     */
    public function delete($userId, $id)
    {
        $this->findUser($userId);
        $motivasi = $this->findMotivasi($userId, $id);
        if ($motivasi == null) {
            return response()->json("Motivasi tidak ditemukan", Response::HTTP_NOT_FOUND);
        }
        $result = $motivasi->delete();
        $response = [
            'message' => 'Motivasi berhasil dihapus',
            'data' => $result
        ];
        return response()->json($response);
    }

    private function findUser($id)
    {
        if (!User::where('id', $id)->exists()) {
            return response()->json("User tidak ditemukan", Response::HTTP_NOT_FOUND);
        }
    }

    private function findMotivasi($userId, $id)
    {
        return Motivasi::where('user_id', $userId)->where('id', $id)->first();
    }
}
