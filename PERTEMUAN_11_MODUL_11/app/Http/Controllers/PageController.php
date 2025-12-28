<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function mahasiswa()
    {
        $mahasiswa = [
            "Fahmi",
            "Ramdan",
            "Alpin",
            "paisal"
        ];

        return view('mahasiswa', compact('mahasiswa'));
    }
}
