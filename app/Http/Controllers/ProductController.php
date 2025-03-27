<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();

        return view("pages.admin", compact("products"));
    }

    public function delete(Request $req) {
        $id = $req->query("id");

        if (!$id) {
            return response()->json([
                'error' => true,
                'message' => 'Masukan query id!'
            ]);
        }

        $res = Product::where('id', $id)->delete();
        if ($res) {
            return response()->json([
                'message' => 'Berhasil menghapus product dengan id'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'ID tidak ada!'
        ]);
    }
}
