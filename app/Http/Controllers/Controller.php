<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    public function login(Request $req) {
        $user = $req->user();
    }
}
