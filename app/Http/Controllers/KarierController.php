<?php

namespace App\Http\Controllers;

use App\Jobs\SyncLamaranToSheets;
use App\Models\LamaranKarir;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KarierController extends Controller
{
    private const PESAN_SUKSES = 'Lamaran Anda telah berhasil dikirimkan. Tim kami akan meninjau lamaran Anda dalam waktu singkat.';

    /**
     * Display all job openings
     */
    public function index()
    {
        return view('karier.index', [
            'openings' => Lowongan::tampil()->orderBy('urutan')->orderBy('id')->get(),
            'activeNav' => 'karier',
        ]);
    }

    /**
     * Show job details and application form
     */
    public function show($slug)
    {
        return view('karier.show', [
            'opening' => Lowongan::tampil()->where('slug', $slug)->firstOrFail(),
            'activeNav' => 'karier',
        ]);
    }

    /**
     * Store application submission
     */
    public function store(Request $request)
    {
        // Honeypot terisi = bot. Pura-pura sukses supaya bot tidak belajar untuk menghindarinya.
        if (filled($request->input('website'))) {
            return redirect()->route('karier.index')->with('success', self::PESAN_SUKSES);
        }

        $validated = $request->validate([
            'posisi' => ['required', 'string', Rule::exists('lowongans', 'slug')->where('tampil', true)],
            'nama_lengkap' => 'required|string|max:255',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'nomor_whatsapp' => 'required|string|max:20',
            'domisili' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|in:S1,S2,S3',
            'jurusan' => 'required|string|max:255',
            'pengalaman_kerja' => 'required|in:<1 tahun,1-3 tahun,3-5 tahun,>5 tahun',
            'sertifikat_iso' => 'required|in:YA,TIDAK',
            'sertifikat_list' => 'nullable|string|max:5000',
            'pengalaman_audit' => 'required|string|max:5000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'portofolio' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'sertifikat_pelatihan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bersedia_fulltime' => 'required|boolean',
        ]);

        // Dokumen berisi data pribadi → disk privat, diunduh admin lewat DokumenLamaranController.
        $folder = ['cv' => 'cv', 'portofolio' => 'portofolio', 'ijazah' => 'ijazah', 'sertifikat_pelatihan' => 'sertifikat'];
        foreach ($folder as $field => $subfolder) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store("lamaran-karir/{$subfolder}", LamaranKarir::DOKUMEN_DISK);
            }
        }

        $lamaran = LamaranKarir::create($validated);

        // Kirim ke Google Sheets. Dengan QUEUE_CONNECTION=sync (shared hosting) job jalan saat
        // itu juga, jadi error webhook jangan sampai menggagalkan lamaran yang sudah tersimpan.
        if (config('google-sheets.webhook_url')) {
            try {
                SyncLamaranToSheets::dispatch($lamaran)->onQueue('default');
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return redirect()->route('karier.index')->with('success', self::PESAN_SUKSES);
    }
}
