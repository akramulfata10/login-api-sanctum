<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UserController extends Controller {
    public function tes() {
        // return Http::dd()->get('http://example.com');
        $response = Http::accept('application/json')->get('http://laravel-api.test:81/api/view-user')->json();
        dd($response);
        // $user = Http::get('http://laravel-api.test:81/api/view-user')->json();
        // return view('view', compact('user'));
        // dd($response);
        // return view('view');
    }
}