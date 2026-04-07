@extends('layouts.app')
@section('content')

<!-- Header detail pengguna, tombol kembali -->
<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('users.index') }}" class="inline-flex items-center rounded-sm border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-arrow-left w-4 text-center"></i>
        <span class="ml-2">Kembali</span>
    </a>
    <h2 class="text-lg font-semibold text-slate-900">Detail Pengguna</h2>
</div>

<!-- Informasi Pengguna -->
<div class="grid gap-4 md:grid-cols-2">
    <div class="rounded-sm border border-slate-200 bg-white p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Pengguna</p>
        <div class="mt-3 space-y-2 text-sm">
            <div class="flex items-center justify-between">
                <span class="text-slate-500">Nama</span>
                <span class="font-medium text-slate-900">{{ $user->nama }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-slate-500">Email</span>
                <span class="font-medium text-slate-900">{{ $user->email }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-slate-500">Role</span>
                <span class="font-medium text-slate-900">{{ $user->is_siswa ? 'Siswa' : 'Admin' }}</span>
            </div>
        </div>

        <div class="mt-4 flex items-center gap-3">
            <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center rounded-sm bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <i class="fa-solid fa-pen-to-square w-4 text-center"></i>
                <span class="ml-2">Edit</span>
            </a>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-sm border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-700 hover:bg-rose-100">
                    <i class="fa-solid fa-trash w-4 text-center"></i>
                    <span class="ml-2">Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <div class="rounded-sm border border-slate-200 bg-white p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Siswa</p>

        @if ($user->siswa)
        <div class="mt-3 space-y-2 text-sm">
            <div class="flex items-center justify-between">
                <span class="text-slate-500">NIS</span>
                <span class="font-medium text-slate-900">{{ $user->siswa->nis }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-slate-500">Kelas</span>
                <span class="font-medium text-slate-900">{{ $user->siswa->kelas }}</span>
            </div>
        </div>
        @else
        <p class="mt-3 text-sm text-slate-500">Pengguna ini tidak memiliki data siswa.</p>
        @endif
    </div>
</div>

@endsection
