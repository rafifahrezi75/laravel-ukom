<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UkomResource;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all artikels
        $artikels = Artikel::latest()->join('kategoris', 'artikels.idkategori', '=', 'kategoris.id')->select(['artikels.*', 'kategoris.kategori'])->paginate(10);

        //return collection of artikels as a resource
        return new UkomResource(true, 'List Data Artikel', $artikels);
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
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul'     => 'required',
            'idkategori'   => 'required',
            'tgl'   => 'required',
            'penulis'   => 'required',
            'status'   => 'required',
            'para1'   => 'required',
            'para2'   => 'required',
            'para3'   => 'required',
            'para4'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/artikels', $image->hashName());

        //create artikels
        $artikel = Artikel::create([
            'image'     => $image->hashName(),
            'judul'     => $request->judul,
            'idkategori'   => $request->idkategori,
            'tgl'   => $request->tgl,
            'penulis'   => $request->penulis,
            'status'   => $request->status,
            'para1'   => $request->para1,
            'para2'   => $request->para2,
            'para3'   => $request->para3,
            'para4'   => $request->para4,
        ]);

        //return response
        return new UkomResource(true, 'Data Artikel Berhasil Ditambahkan!', $artikel);
    }

    /**
     * show
     *
     * @param  mixed $artikel
     * @return void
     */
    public function show($id)
    {
        //find artikel by ID
        $artikel = Artikel::join('kategoris', 'artikels.idkategori', '=', 'kategoris.id')->select(['artikels.*', 'kategoris.id', 'kategoris.kategori'])->find($id);

        //return single artikel as a resource
        return new UkomResource(true, 'Detail Data Artikel!', $artikel);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $artikel
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'judul'     => 'required',
            'idkategori'   => 'required',
            'tgl'   => 'required',
            'penulis'   => 'required',
            'status'   => 'required',
            'para1'   => 'required',
            'para2'   => 'required',
            'para3'   => 'required',
            'para4'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find artikel by ID
        $artikel = Artikel::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/artikels', $image->hashName());

            //delete old image
            Storage::delete('public/artikels/'.basename($artikel->image));

            //update artikel with new image
            $artikel->update([
                'image'     => $image->hashName(),
                'judul'     => $request->judul,
                'idkategori'   => $request->idkategori,
                'tgl'   => $request->tgl,
                'penulis'   => $request->penulis,
                'status'   => $request->status,
                'para1'   => $request->para1,
                'para2'   => $request->para2,
                'para3'   => $request->para3,
                'para4'   => $request->para4,
            ]);

        } else {

            //update artikel without image
            $artikel->update([
                'judul'     => $request->judul,
                'idkategori'   => $request->idkategori,
                'tgl'   => $request->tgl,
                'penulis'   => $request->penulis,
                'status'   => $request->status,
                'para1'   => $request->para1,
                'para2'   => $request->para2,
                'para3'   => $request->para3,
                'para4'   => $request->para4,
            ]);
        }

        //return response
        return new UkomResource(true, 'Data Artikel Berhasil Diubah!', $artikel);
    }

    /**
     * destroy
     *
     * @param  mixed $artikel
     * @return void
     */
    public function destroy($id)
    {

        //find artikels by ID
        $artikel = Artikel::find($id);

        //delete image
        Storage::delete('public/artikels/'.basename($artikel->image));

        //delete artikels
        $artikel->delete();

        //return response
        return new UkomResource(true, 'Data Artikel Berhasil Dihapus!', null);
    }

    /**
     * indexartikel
     *
     * @return void
     */
    public function indexartikel()
    {
        //get all artikels
        $artikels = Artikel::latest()->join('kategoris', 'artikels.idkategori', '=', 'kategoris.id')->select(['artikels.*', 'kategoris.kategori'])->paginate(20);

        //return collection of artikels as a resource
        return new UkomResource(true, 'List Data Artikel', $artikels);
    }

    /**
     * indexartikel1
     *
     * @return void
     */
    public function indexartikel1()
    {
        //get all artikels
        $artikels = Artikel::latest()->join('kategoris', 'artikels.idkategori', '=', 'kategoris.id')->select(['artikels.*', 'kategoris.kategori'])->get();

        //return collection of artikels as a resource
        return new UkomResource(true, 'List Data Artikel', $artikels);
    }
}
