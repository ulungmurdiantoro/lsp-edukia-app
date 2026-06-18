<?php

namespace App\Http\Controllers;

use App\Models\LamaranKarir;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KarierController extends Controller
{
    /**
     * Static job openings configuration
     */
    private function getOpenings()
    {
        return [
            [
                'slug' => 'management-representative',
                'judul' => 'Management Representative (MR) - LSP Edukia',
                'deskripsi' => 'Kami mencari Management Representative yang berpengalaman untuk bergabung dengan tim LSP Edukia. Posisi ini bertanggung jawab atas pengelolaan sistem mutu dan audit internal.',
                'kategori' => 'Management',
                'lokasi' => 'Mijen, Semarang Barat',
                'tipe' => 'Full-time',
                'requirements' => [
                    'Pendidikan minimal S1',
                    'Pengalaman kerja di bidang Penjaminan Mutu minimal 1 tahun',
                    'Memiliki sertifikat kompetensi di bidang ISO 21001 atau ISO 17024 (lebih diutamakan)',
                    'Terampil dalam mengelola audit internal dan sistem mutu',
                    'Mampu berkomunikasi dengan baik',
                    'Bersedia bekerja penuh waktu (full-time) di lokasi Mijen, Semarang Barat',
                ],
                'responsibilities' => [
                    'Mengelola dan mengembangkan sistem mutu organisasi',
                    'Melakukan audit internal secara berkala',
                    'Membuat laporan mutu kepada manajemen',
                    'Memastikan kepatuhan terhadap standar ISO 21001',
                    'Berkoordinasi dengan berbagai departemen untuk perbaikan berkelanjutan',
                ],
            ],
        ];
    }

    /**
     * Display all job openings
     */
    public function index()
    {
        $openings = $this->getOpenings();
        return view('karier.index', [
            'openings' => $openings,
            'activeNav' => 'karier',
        ]);
    }

    /**
     * Show job details and application form
     */
    public function show($slug)
    {
        $openings = $this->getOpenings();
        $opening = collect($openings)->firstWhere('slug', $slug);

        if (!$opening) {
            abort(404);
        }

        return view('karier.show', [
            'opening' => $opening,
            'activeNav' => 'karier',
        ]);
    }

    /**
     * Store application submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'posisi' => 'required|string',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'nomor_whatsapp' => 'required|string|max:20',
            'domisili' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|in:S1,S2,S3',
            'jurusan' => 'required|string|max:255',
            'pengalaman_kerja' => 'required|in:<1 tahun,1-3 tahun,3-5 tahun,>5 tahun',
            'sertifikat_iso' => 'required|in:YA,TIDAK',
            'sertifikat_list' => 'nullable|string',
            'pengalaman_audit' => 'required|string',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'portofolio' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'sertifikat_pelatihan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bersedia_fulltime' => 'required|boolean',
        ]);

        // Store file paths
        if ($request->hasFile('cv')) {
            $validated['cv'] = $request->file('cv')->store('lamaran-karir/cv', 'public');
        }
        if ($request->hasFile('portofolio')) {
            $validated['portofolio'] = $request->file('portofolio')->store('lamaran-karir/portofolio', 'public');
        }
        if ($request->hasFile('ijazah')) {
            $validated['ijazah'] = $request->file('ijazah')->store('lamaran-karir/ijazah', 'public');
        }
        if ($request->hasFile('sertifikat_pelatihan')) {
            $validated['sertifikat_pelatihan'] = $request->file('sertifikat_pelatihan')->store('lamaran-karir/sertifikat', 'public');
        }

        LamaranKarir::create($validated);

        return redirect()->route('karier.index')
            ->with('success', 'Lamaran Anda telah berhasil dikirimkan. Tim kami akan meninjau lamaran Anda dalam waktu singkat.');
    }
}
