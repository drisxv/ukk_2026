<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UmpanBalik;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;

class UmpanBalikController extends Controller
{

    /*
        Memeriksa akses pengguna untuk melihat daftar umpan balik dengan memanggil metode authorizeAdmin().
        Mengambil data umpan balik beserta relasi user dan aspirasi menggunakan UmpanBalik::with(['user', 'aspirasi'])->latest()->paginate(10).
        Mengembalikan view 'umpan_balik.index' dengan data umpan balik yang telah diambil untuk ditampilkan kepada pengguna.
    */
    public function index()
    {
        $this->authorizeAdmin();

        $umpanBaliks = UmpanBalik::with(['user', 'aspirasi'])->latest()->paginate(10);

        return view('umpan_balik.index', compact('umpanBaliks'));
    }

    /*
        Memeriksa akses pengguna untuk membuat umpan balik baru dengan memanggil metode authorizeAdmin().
        Mengambil data aspirasi terbaru dengan hanya mengambil field id, judul, dan lokasi menggunakan Aspirasi::query()->latest()->get(['id', 'judul', 'lokasi']).
        Mengembalikan view 'umpan_balik.create' dengan data aspirasi yang telah diambil untuk ditampilkan kepada pengguna.
     */
    public function create()
    {
        $this->authorizeAdmin();

        $aspirasis = Aspirasi::query()->latest()->get(['id', 'judul', 'lokasi']);

        return view('umpan_balik.create', compact('aspirasis'));
    }

    /*
        Memeriksa akses pengguna untuk membuat umpan balik baru dengan memanggil metode authorizeAdmin().
        Melakukan validasi data yang diterima dari request untuk memastikan bahwa semua field yang diperlukan telah diisi dengan benar.
        Melakukan input data umpan balik baru menggunakan UmpanBalik::create() dengan data yang telah divalidasi.
        Mengarahkan pengguna kembali ke halaman index umpan balik dengan pesan sukses jika umpan balik berhasil dikirim.
    */
    public function store(Request $request)
    {
        $request->validate([
            'aspirasi_id' => ['required', 'integer', 'exists:aspirasi,id'],
            'isi_umpan_balik' => ['required', 'string'],
            'status_penyelesaian' => ['nullable', 'in:pending,proses,selesai'],
            'redirect_to' => ['nullable', 'string'],
        ]);
        if (!Auth::check()) {
            abort(403, 'Akses Ditolak.');
        }
        $user = Auth::user();
        $aspirasi = Aspirasi::query()->findOrFail((int) $request->aspirasi_id);
        if ($user?->is_siswa) {
            $siswaId = $user?->siswa?->id;
            if (!$siswaId || (int) $aspirasi->siswa_id !== (int) $siswaId) {
                abort(403, 'Akses Ditolak.');
            }
        }
        $statusPenyelesaian = $user?->is_siswa ? 'pending' : ($request->status_penyelesaian ?? 'pending');
        UmpanBalik::create([
            'user_id' => Auth::id(),
            'aspirasi_id' => (int) $aspirasi->id,
            'isi_umpan_balik' => $request->isi_umpan_balik,
            'status_penyelesaian' => $statusPenyelesaian,
        ]);

        return redirect()->route('umpan-balik.index')->with('success', 'Umpan balik berhasil dikirim.');
    }

    /*
        Memeriksa akses pengguna untuk melihat detail umpan balik dengan memanggil metode authorizeAdmin().
        Memuat relasi user dan aspirasi untuk data umpan balik yang diminta.
        Mengembalikan view 'umpan_balik.show' dengan data umpan balik yang telah diambil untuk ditampilkan kepada pengguna.
    */
    public function show(UmpanBalik $umpan_balik)
    {
        $this->authorizeAdmin();

        $umpan_balik->loadMissing(['user', 'aspirasi']);

        return view('umpan_balik.show', ['umpanBalik' => $umpan_balik]);
    }

    /*
        Memeriksa apakah pengguna yang sedang login memiliki peran sebagai admin dan tidak memiliki peran sebagai siswa.
        Jika pengguna tidak memiliki peran sebagai admin atau memiliki peran sebagai siswa, maka akses akan ditolak dengan mengembalikan respons 403 (Forbidden) dan pesan yang sesuai.
    */
    private function authorizeAdmin(): void
    {
        $user = Auth::user();
        $isSiswa = ($user?->is_siswa === true) || ($user?->is_siswa === 1) || ($user?->is_siswa === 'true');

        if (!Auth::check() || $isSiswa) {
            abort(403, 'Akses Ditolak.');
        }
    }


}
