<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /*
        Memeriksa akses pengguna untuk melihat daftar pengguna dengan memanggil metode authorizePengguna().
        Mengambil data pengguna beserta relasi siswa serta mengurutkan data pengguna berdasarkan nama menggunakan User::with('siswa')->orderBy('nama')->get().
        Mengembalikan view 'users.index' dengan data pengguna yang telah diambil untuk ditampilkan kepada pengguna.
    */
    public function index()
    {
        $this->authorizePengguna();

        $users = User::with('siswa')->orderBy('nama')->get();

        return view('users.index', compact('users'));
    }

    /*
        Memeriksa akses pengguna untuk melihat detail pengguna dengan memanggil metode authorizePengguna().
        Mencari data pengguna berdasarkan $id menggunakan User::with('siswa')->findOrFail($id).
        Mengembalikan view 'users.show' dengan data pengguna yang telah diambil untuk ditampilkan kepada pengguna.
    */
    public function show($id)
    {
        $this->authorizePengguna();

        $user = User::with('siswa')->findOrFail($id);

        return view('users.show', compact('user'));
    }

    /*
        Memeriksa akses pengguna untuk membuat pengguna baru dengan memanggil metode authorizePengguna().
        Mengembalikan view 'users.create'.
    */
    public function create()
    {
        $this->authorizePengguna();
        return view('users.create');
    }

    /*
        Memeriksa akses pengguna untuk membuat pengguna baru dengan memanggil metode authorizePengguna().
        Melakukan validasi data yang diterima dari request untuk memastikan bahwa semua field yang diperlukan telah diisi dengan benar, termasuk validasi khusus untuk siswa jika is_siswa bernilai true.
        Melakukan input data pengguna baru menggunakan User::create() dan jika is_siswa bernilai true, juga membuat data siswa terkait menggunakan relasi siswa() pada model User.
        Mengarahkan pengguna kembali ke halaman index pengguna dengan pesan sukses jika pengguna berhasil ditambahkan.
    */
    public function store(Request $request)
    {
        $this->authorizePengguna();

        $isSiswa = $request->boolean('is_siswa');

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('users', 'nama')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:6'],
            'is_siswa' => ['required', 'boolean'],
            'nis' => [$isSiswa ? 'required' : 'nullable', 'integer', 'digits_between:1,10', Rule::unique('siswa', 'nis')],
            'kelas' => [$isSiswa ? 'required' : 'nullable', 'string', 'max:10'],
        ]);

        DB::transaction(function () use ($validated, $isSiswa) {
            $user = User::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_siswa' => $isSiswa,
            ]);

            if ($isSiswa) {
                $user->siswa()->create([
                    'nis' => $validated['nis'],
                    'kelas' => $validated['kelas'],
                ]);
            }
        });

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /*
        Memeriksa akses pengguna untuk melihat form edit pengguna dengan memanggil metode authorizePengguna().
        Mencari data pengguna berdasarkan $id menggunakan User::findOrFail($id).
        Mengembalikan view 'users.edit' dengan data pengguna yang telah diambil untuk ditampilkan kepada pengguna.
    */
    public function edit($id)
    {
        $this->authorizePengguna();

        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /*
        Memeriksa akses pengguna untuk memperbarui data pengguna dengan memanggil metode authorizePengguna().
        Mencari data pengguna berdasarkan $id menggunakan User::findOrFail($id).
        Melakukan validasi data yang diterima dari request untuk memastikan bahwa semua field yang diperlukan telah diisi dengan benar, termasuk validasi khusus untuk siswa jika is_siswa bernilai true.
        Melakukan pembaruan data pengguna menggunakan metode update() pada model User dan jika is_siswa bernilai true, juga memperbarui atau membuat data siswa terkait menggunakan relasi siswa() pada model User.
        Mengarahkan pengguna kembali ke halaman index pengguna dengan pesan sukses jika pengguna berhasil diperbarui.
    */
    public function update(Request $request, $id)
    {
        $this->authorizePengguna();

        $user = User::findOrFail($id);

        $isSiswa = $request->boolean('is_siswa');
        $siswaId = $user->siswa?->id;

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('users', 'nama')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'is_siswa' => ['required', 'boolean'],
            'nis' => [$isSiswa ? 'required' : 'nullable', 'integer', 'digits_between:1,10', Rule::unique('siswa', 'nis')->ignore($siswaId)],
            'kelas' => [$isSiswa ? 'required' : 'nullable', 'string', 'max:10'],
        ]);

        DB::transaction(function () use ($user, $validated, $isSiswa) {
            $user->update([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'is_siswa' => $isSiswa,
                ...(filled($validated['password'] ?? null) ? ['password' => Hash::make($validated['password'])] : []),
            ]);

            if ($isSiswa) {
                Siswa::updateOrCreate(
                    ['user_id' => $user->id],
                    ['nis' => $validated['nis'], 'kelas' => $validated['kelas']]
                );
            } else {
                $user->siswa()->delete();
            }
        });

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /*
        Memeriksa akses pengguna untuk menghapus pengguna dengan memanggil metode authorizePengguna().
        Mencari data pengguna berdasarkan $id menggunakan User::findOrFail($id).
        Menghapus data pengguna menggunakan metode delete() pada model User.
        Mengarahkan pengguna kembali ke halaman index pengguna dengan pesan sukses jika pengguna berhasil dihapus.
    */
    public function destroy($id)
    {
        $this->authorizePengguna();

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /*
        Memeriksa akses pengguna untuk melihat daftar pengguna dengan memanggil metode authorizePengguna().
        Mengambil data pengguna beserta relasi siswa serta mengurutkan data pengguna berdasarkan nama menggunakan User::with('siswa')->orderBy('nama')->get().
        Mengembalikan view 'users.index' dengan data pengguna yang telah diambil untuk ditampilkan kepada pengguna.
    */
    private function authorizePengguna(): void
    {
        if (!Auth::check() || Auth::user()->is_siswa == 'false') {
            abort(403, 'Akses Ditolak.');
        }
    }
}
