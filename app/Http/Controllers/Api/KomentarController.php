<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UkomResource;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KomentarController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all kometars
        $kometars = Komentar::latest()->join('users', 'komentars.iduser', '=', 'users.id')->select(['komentars.*', 'users.name'])->paginate(5);

        //return collection of kometars as a resource
        return new UkomResource(true, 'List Data Komentar', $kometars);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'idartikel'   => 'required',
            'idkomen'   => 'required',
            'aksi'   => 'required',
            'iduser'   => 'required',
            'tglkomen'   => 'required',
            'statuskomen'   => 'required',
            'komentar'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create komentar
        $komentar = Komentar::create([
            'idartikel'   => $request->idartikel,
            'idkomen'   => $request->idkomen,
            'aksi'   => $request->aksi,
            'iduser'   => $request->iduser,
            'tglkomen'   => $request->tglkomen,
            'statuskomen'   => $request->statuskomen,
            'komentar'   => $request->komentar,
        ]);

        //return response
        return new UkomResource(true, 'Data Komentar Berhasil Ditambahkan!', $komentar);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        //find komentar by ID
        $komentar = Komentar::join('users', 'komentars.iduser', '=', 'users.id')->select(['komentars.*', 'users.name'])->find($id);

        //return single komentar as a resource
        return new UkomResource(true, 'Detail Data Komentar!', $komentar);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'statuskomen'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find komentar by ID
        $komentar = Komentar::find($id);

            //update komentar
            $komentar->update([
                'statuskomen'   => $request->statuskomen,
            ]);

        //return response
        return new UkomResource(true, 'Data Komentar Berhasil Diubah!', $komentar);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {

        //find komentar by ID
        $komentar = Komentar::find($id);

        //delete post
        $komentar->delete();

        //return response
        return new UkomResource(true, 'Data Komentar Berhasil Dihapus!', null);
    }

    /**
     * indexkomentar
     *
     * @return void
     */
    public function indexkomentar()
    {
        //get all kometars
        $kometars = Komentar::join('users', 'komentars.iduser', '=', 'users.id')->select(['komentars.*', 'users.name'])->get();

        //return collection of kometars as a resource
        return new UkomResource(true, 'List Data Komentar', $kometars);
    }
}
