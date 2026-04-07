<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    /* 
        Mengambil data user dari session menggunakan Auth::user(),
        Memeriksa apakah user tersebut memiliki peran sebagai admin atau siswa, dan kemudian mengambil data aspirasi yang sesuai berdasarkan peran tersebut.
            Jika user adalah admin, maka semua data aspirasi akan diambil menggunakan Aspirasi::all(). 
            Jika user adalah siswa, maka hanya data aspirasi yang terkait dengan siswa tersebut yang akan diambil menggunakan Aspirasi::where('siswa_id', $siswaId)->get().
        Mengembalikan view 'aspirasi.index' dengan data aspirasi yang telah diambil untuk ditampilkan kepada pengguna.
    */
    public function index()
    {
        $user = Auth::user();

        if (!$user?->is_siswa) {
            $aspirasis = Aspirasi::with('siswa.user')->get();
        } else {
            $siswaId = $user?->siswa?->id;
            $aspirasis = $siswaId
                ? Aspirasi::with('siswa.user')->where('siswa_id', $siswaId)->get()
                : collect();
        }
        return view('aspirasi.index', compact('aspirasis'));
    }

    /* 
        Menerima parameter $id
        Mencari data aspirasi berdasarkan $id menggunakan Aspirasi::findOrFail($id).
        Mengambil data umpan balik yang terkait dengan aspirasi tersebut menggunakan $aspirasis->umpanBalik()->get().
        Mengembalikan view 'aspirasi.show' dengan data aspirasi dan umpan balik yang telah diambil untuk ditampilkan kepada pengguna.
    */
    public function show($id)
    {
        $aspirasis = Aspirasi::findOrFail($id);
        $umpanBalik = $aspirasis->umpanBalik()->get();

        return view('aspirasi.show', compact('aspirasis', 'umpanBalik'));
    }

    /* 
        Memeriksa akses pengguna untuk membuat aspirasi baru dengan memanggil metode authorizeSiswaCreate().
        Menegembalikan view 'aspirasi.create'.
    */
    public function create()
    {
        $this->authorizeSiswaCreate();
        return view('aspirasi.create');
    }

    /* 
        Memeriksa akses pengguna untuk membuat aspirasi baru dengan memanggil metode authorizeSiswaCreate().
        Melakukan validasi data yang diterima dari request untuk memastikan bahwa semua field yang diperlukan telah diisi dengan benar.
        Melakukan input data aspirasi baru menggunakan Aspirasi::create() dengan data yang telah divalidasi, termasuk mengaitkan aspirasi dengan siswa yang sedang login.
        Mengarahkan pengguna kembali ke halaman index aspirasi dengan pesan sukses jika aspirasi berhasil dikirim.
    */
    public function store(Request $request)
    {
        $this->authorizeSiswaCreate();

        $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:100',
            'keterangan' => 'required|string',

        ]);
        Aspirasi::create([
            'siswa_id' => Auth::user()->siswa->id,
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dikirim.');
    }

    /*
        Memeriksa apakah pengguna yang sedang login memiliki peran sebagai siswa dan memiliki data siswa yang terkait.
        Jika pengguna tidak memiliki peran sebagai siswa atau tidak memiliki data siswa, maka akses akan ditolak dengan mengembalikan respons 403 (Forbidden) dan pesan yang sesuai.
    */
    private function authorizeSiswaCreate(): void
    {
        $user = Auth::user();

        if (!Auth::check() || !$user?->is_siswa) {
            abort(403, 'Akses Ditolak.');
        }

        if (!$user?->siswa) {
            abort(403, 'Data siswa belum tersedia.');
        }
    }
}
