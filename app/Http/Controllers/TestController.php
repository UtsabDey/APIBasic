<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return ['name' => 'Utsab Dey', 'email' => 'utsabdey@gmail.com', 'password' => 'password@gmail.com'];
    }
}
