<?php

namespace App\Http\Controllers;

class GuruMiDbController extends Controller
{
    public function index()
    {
        // ===================== RETURN =====================
        return view('guru.dashboard');
    }
}