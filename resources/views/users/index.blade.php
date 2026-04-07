@extends('layouts.app')
@section('content')

<!-- Header daftar pengguna, tombol daftar pengguna -->
<div class="mb-4 w-full flex">
    <h2 class="text-lg font-semibold text-slate-900">Daftar Pengguna</h2>
    <a href="{{ route('users.create') }}" class="ml-auto inline-flex items-center rounded-sm bg-blue-500 px-3 py-2 text-sm font-medium text-white hover:bg-blue-600">
        <i class="fa-solid fa-plus w-4 text-center"></i>
        <span class="ml-1">Tambah Pengguna</span>
    </a>
</div>

<div class="w-full overflow-x-auto rounded-sm border border-slate-200 bg-white">
    <!-- Tabel daftar pengguna -->
    <table class="min-w-full divide-y divide-slate-200">
        <!-- Header tabel pengguna -->
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Role</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">NIS</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Kelas</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Aksi</th>
            </tr>
        </thead>
        <!-- Isi tabel pengguna -->
        <tbody class="divide-y divide-slate-200">
            @forelse ($users as $user)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 text-sm text-slate-800">{{ $user->nama }}</td>
                <td class="px-4 py-3 text-sm text-slate-800">{{ $user->email }}</td>
                <td class="px-4 py-3 text-sm text-slate-800">{{ $user->is_siswa ? 'Siswa' : 'Admin' }}</td>
                <td class="px-4 py-3 text-sm text-slate-800">{{ $user->siswa?->nis ?? '-' }}</td>
                <td class="px-4 py-3 text-sm text-slate-800">{{ $user->siswa?->kelas ?? '-' }}</td>
                <td class="px-4 py-3 text-sm">
                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ml-3 text-rose-600 hover:underline" onclick="return confirm('Are you sure?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada pengguna.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection