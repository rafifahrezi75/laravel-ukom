<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UkomResource;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all kategoris
        $kategoris = Kategori::latest()->paginate(5);

        //return collection of posts as a resource
        return new UkomResource(true, 'List Data Kategori', $kategoris);
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
            'kategori'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $kategori = Kategori::create([
            'kategori'   => $request->kategori,
        ]);

        //return response
        return new UkomResource(true, 'Data Kategori Berhasil Ditambahkan!', $kategori);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $kategori = Kategori::find($id);

        //return single post as a resource
        return new UkomResource(true, 'Detail Data Kategori!', $kategori);
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
            'kategori'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $kategori = Kategori::find($id);

        $kategori->update([
            'kategori'   => $request->kategori,
        ]);

        //return response
        return new UkomResource(true, 'Data Kategori Berhasil Diubah!', $kategori);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {

        //find post by ID
        $kategori = Kategori::find($id);

        //delete post
        $kategori->delete();

        //return response
        return new UkomResource(true, 'Data Kategori Berhasil Dihapus!', null);
    }

    /**
     * indexkategori
     *
     * @return void
     */
    public function indexkategori()
    {
        //get all kategoris
        $kategoris = Kategori::latest()->get();

        //return collection of posts as a resource
        return new UkomResource(true, 'List Data Kategori', $kategoris);
    }
}
