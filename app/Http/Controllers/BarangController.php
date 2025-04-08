<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BarangController extends Controller
{
    public function index()
    {
        return Barang::all();
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                'harga' => 'required|string',
                'stok' => 'required|integer',
            ]);

            Barang::create([
                'nama' => $request->input('nama'),
                'harga' => $request->input('harga'),
                'stok' => $request->input('stok'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang diinput tidak valid!'
            ], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|string',
                'payload' => 'required|array',
                'payload.nama' => 'required|string',
                'payload.harga' => 'required|string',
                'payload.stok' => 'required|string',
            ]);

            $barang = Barang::find($request->id);

            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barang dengan id ' + $request->id + ' tidak ditemukan.'
                ]);
            }

            Barang::where('id', $request->id)->update([
                'nama' => $request->input('payload.nama'),
                'harga' => $request->input('payload.harga'),
                'stok' => $request->input('payload.stok'),
            ]);

            return response()->json(Barang::find($request->id));

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang diinput tidak valid!',
                'error' => $e->errors()
            ], 400);
        }
    }

    public function remove(Request $request) {
        try {
            $request->validate([
                'id' => 'required|string'
            ]);

            $barang = Barang::find($request->id);

            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barang dengan id ' + $request->id + ' tidak ditemukan.'
                ]);
            }

            Barang::where('id', $request->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Barang telah dihapus.',
                'delete' => $barang
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang di input tidak valid!',
                'error' => $e->errors()
            ]);
        }
    }
}
