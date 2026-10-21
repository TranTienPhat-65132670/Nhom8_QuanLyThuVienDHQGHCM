<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    // trang chủ
    public function index()
    {
        return view('auth.member');
    }

    // trang nội quy
    public function rule()
    {
        return view('client.rule');
    }

    // trang hướng dẫn
    public function guide()
    {
        return view('client.guide');
    }
}
