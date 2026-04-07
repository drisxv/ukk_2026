@extends('layouts.app')
@section('content')

<!-- Header tambah pengguna -->
<div class="mb-6 flex items-center gap-3">
	<a href="{{ route('users.index') }}" class="inline-flex items-center rounded-sm border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
		<i class="fa-solid fa-arrow-left w-4 text-center"></i>
		<span class="ml-2">Kembali</span>
	</a>
	<h2 class="text-lg font-semibold text-slate-900">Tambah Pengguna</h2>
</div>

<!-- Formulir tambah pengguna -->
<form action="{{ route('users.store') }}" method="POST" class="space-y-6">
	@csrf
	<div class="grid gap-4 md:grid-cols-2">
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Nama</label>
			<input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Nama pengguna" required>
		</div>
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
			<input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="email@contoh.com" required>
		</div>
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Password</label>
			<input type="password" name="password" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Minimal 6 karakter" required>
		</div>
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Role</label>
			<select name="is_siswa" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" required>
				<option value="0" {{ old('is_siswa', '0') == '0' ? 'selected' : '' }}>Admin</option>
				<option value="1" {{ old('is_siswa') == '1' ? 'selected' : '' }}>Siswa</option>
			</select>
			<p class="mt-1 text-xs text-slate-500">Jika memilih Siswa, maka NIS & Kelas wajib diisi.</p>
		</div>
	</div>

	<!-- Formulir Data Siswa -->
	<div class="rounded-sm border border-slate-200 bg-slate-50 p-4">
		<p class="mb-3 text-sm font-semibold text-slate-800">Data Siswa</p>
		<div class="grid gap-4 md:grid-cols-2">
			<div>
				<label class="mb-1 block text-sm font-medium text-slate-700">NIS</label>
				<input type="number" name="nis" value="{{ old('nis') }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Contoh: 12345">
			</div>
			<div>
				<label class="mb-1 block text-sm font-medium text-slate-700">Kelas</label>
				<input type="text" name="kelas" value="{{ old('kelas') }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Contoh: XI RPL 1">
			</div>
		</div>
	</div>

	<div class="flex items-center gap-3">
		<button type="submit" class="inline-flex items-center rounded-sm bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
			<i class="fa-solid fa-floppy-disk w-4 text-center"></i>
			<span class="ml-2">Simpan</span>
		</button>
		<a href="{{ route('users.index') }}" class="inline-flex items-center rounded-sm border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
			Batal
		</a>
	</div>
</form>

@endsection