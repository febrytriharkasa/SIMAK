<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10); // paginate 10 per halaman
        return view('user.index', compact('users'));
    }

}
