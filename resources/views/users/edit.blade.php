@extends('layouts.app')
@section('content')

<!-- Header edit pengguna, tombol kembali -->
<div class="mb-6 flex items-center gap-3">
	<a href="{{ route('users.index') }}" class="inline-flex items-center rounded-sm border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
		<i class="fa-solid fa-arrow-left w-4 text-center"></i>
		<span class="ml-2">Kembali</span>
	</a>
	<h2 class="text-lg font-semibold text-slate-900">Edit Pengguna</h2>
</div>

<!-- Formulir edit pengguna -->
<form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
	@csrf
	@method('PUT')
	<div class="grid gap-4 md:grid-cols-2">
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Nama</label>
			<input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" required>
		</div>
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
			<input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" required>
		</div>
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Password (opsional)</label>
			<input type="password" name="password" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Kosongkan jika tidak diganti">
		</div>
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Role</label>
			<select name="is_siswa" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" required>
				@php
				$currentIsSiswa = old('is_siswa', $user->is_siswa ? '1' : '0');
				@endphp
				<option value="0" {{ $currentIsSiswa == '0' ? 'selected' : '' }}>Admin</option>
				<option value="1" {{ $currentIsSiswa == '1' ? 'selected' : '' }}>Siswa</option>
			</select>
		</div>
	</div>

	<!-- Formulir Data Siswa -->
	<div class="rounded-sm border border-slate-200 bg-slate-50 p-4">
		<div class="mb-3 flex items-center justify-between">
			<p class="text-sm font-semibold text-slate-800">Data Siswa</p>
			<span class="text-xs text-slate-500">{{ $user->siswa ? 'Terhubung' : 'Belum ada' }}</span>
		</div>
		<p class="mb-2 text-xs text-slate-500">Harap isi data siswa, jika </p>

		<div class="grid gap-4 md:grid-cols-2">
			<div>
				<label class="mb-1 block text-sm font-medium text-slate-700">NIS</label>
				<input type="number" name="nis" value="{{ old('nis', $user->siswa?->nis) }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Contoh: 12345">
			</div>
			<div>
				<label class="mb-1 block text-sm font-medium text-slate-700">Kelas</label>
				<input type="text" name="kelas" value="{{ old('kelas', $user->siswa?->kelas) }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Contoh: XI RPL 1">
			</div>
		</div>
	</div>

	<div class="flex items-center gap-3">
		<button type="submit" class="inline-flex items-center rounded-sm bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
			<i class="fa-solid fa-floppy-disk w-4 text-center"></i>
			<span class="ml-2">Simpan Perubahan</span>
		</button>
		<a href="{{ route('users.index') }}" class="inline-flex items-center rounded-sm border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
			Batal
		</a>
	</div>
</form>

@endsection