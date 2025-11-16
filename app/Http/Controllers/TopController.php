<?php

namespace App\Http\Controllers;

use App\Models\Top;

class TopController extends Controller
{
    public function index()
    {
        $topPlayers = Top::top5Players();
        return view('siswa.home', compact('topPlayers'));
    }
}
