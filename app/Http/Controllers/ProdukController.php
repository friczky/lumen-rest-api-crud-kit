<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{

    public function index()
    {
        $produk = Produk::all();

        return response()->json($produk);
    }

    public function show($id)
    {
        $produk = Produk::find($id);

        if(!$produk) {
            return response()->json([
                'message' => 'Produk not found'
            ], 404);
        }

        return response()->json($produk);
    }


    public function create(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'harga' => 'required|integer',
            'warna' => 'required',
            'kondisi' => 'required|in:baru,lama',
            'deskripsi' => 'string',
        ]);

        $data = $request->all();
        $produk = Produk::create($data);

        return response()->json($produk);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'nama' => 'string',
            'harga' => 'integer',
            'warna' => 'string',
            'kondisi' => 'in:baru,lama',
            'deskripsi' => 'string',
        ]);

        $produk = Produk::find($id);

        if(!$produk){
            return response()->json([
                'message' => 'Produk not found'
            ], 404);
        }

        $data = $request->all();
        $produk->fill($data);
        $produk->save();
        $response = [
            'meta' => [
                'status' => 'success',
                'message' => 'Produk updated'
            ],
            'data' => $produk
        ];
        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);

        if(!$produk){
            return response()->json([
                'message' => 'Produk not found'
            ], 404);
        }

        $produk->delete();
        return response()->json([
            'message' => 'Produk deleted'
        ]);
    }


}
