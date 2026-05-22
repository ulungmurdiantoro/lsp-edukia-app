<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;

class PageController extends Controller
{
    public function home()
    {
        $kegiatan = Kegiatan::aktif()->take(9)->get();
        return view('index', compact('kegiatan'))->with('activeNav', 'home');
    }

    public function informasi()
    {
        return view('informasi-publik')->with('activeNav', 'informasi');
    }

    public function tentang()
    {
        return view('tantang-kami')->with('activeNav', 'tentang');
    }

    public function skema()
    {
        return view('skema-sertifikasi')->with('activeNav', 'skema');
    }

    public function sertifikat()
    {
        return view('sertifikat')->with('activeNav', 'sertifikat');
    }

    public function kegiatan()
    {
        $kegiatan = Kegiatan::aktif()->paginate(12);
        return view('kegiatan.index', compact('kegiatan'))->with('activeNav', '');
    }
}
