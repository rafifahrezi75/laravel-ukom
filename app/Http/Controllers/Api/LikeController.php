<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UkomResource;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    /**
     * index
     *
     * @return void
     */
    public function indexLike()
    {
        //get all likes
        $likes = Like::latest()->join('artikels', 'likes.idartikel', '=', 'artikels.id')
        ->join('kategoris', 'artikels.idkategori', '=', 'kategoris.id')
        ->select(['likes.*', 'kategoris.kategori', 'artikels.image', 'artikels.judul',
        'artikels.tgl', 'artikels.penulis', 'artikels.status', 'artikels.para1', 'artikels.para2', 'artikels.para3', 'artikels.para4'])->get();

        //return collection of likes as a resource
        return new UkomResource(true, 'List Data Likes', $likes);
    }

    public function checkLike(Request $request)
    {
        $existingLike = Like::where('iduser', $request->iduser)
            ->where('idartikel', $request->idartikel)
            ->first();

        if ($existingLike) {
            return response()->json([
                'liked' => true,
            ], 200);
        }

        return response()->json([
            'liked' => false,
        ], 200);
    }


    public function like(Request $request)
    {

        $existingLike = Like::where('iduser', $request->iduser)
            ->where('idartikel', $request->idartikel)
            ->first();

        if ($existingLike) {
            return response()->json([
                'success' => false,
                'message' => 'Anda telah memberi like pada artikel ini sebelumnya.'
            ], 422);
        }

        $like = new Like();
        $like->iduser = $request->iduser;
        $like->idartikel = $request->idartikel;
        $like->save();

        return response()->json([
            'success' => true,
            'message' => 'Anda telah memberi like pada artikel ini.',
        ],200);
    }

    public function unlike(Request $request)
    {

        $like = Like::where('iduser', $request->iduser)
            ->where('idartikel', $request->idartikel)
            ->first();

        if (!$like) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat unlike artikel ini karena Anda belum memberi like.'
            ], 422);
        }

        $like->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anda telah melakukan unlike pada artikel ini.'
        ],200);
    }
}
