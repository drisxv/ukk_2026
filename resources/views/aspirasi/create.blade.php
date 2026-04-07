@extends('layouts.app')
@section('content')

<!-- Header form, dan tombol kembali -->
<div class="mb-6 flex items-center gap-3">
	<a href="{{ route('aspirasi.index') }}" class="inline-flex items-center rounded-sm border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
		<i class="fa-solid fa-arrow-left w-4 text-center"></i>
		<span class="ml-2">Kembali</span>
	</a>
	<h2 class="text-lg font-semibold text-slate-900">Buat Aspirasi</h2>
</div>

<!-- Form untuk membuat aspirasi, yang nantinya akan dikirim ke route 'aspirasi.store' -->
<form action="{{ route('aspirasi.store') }}" method="POST" class="space-y-6">
	@csrf
	<div class="grid gap-4 md:grid-cols-2">
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Judul</label>
			<input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Judul aspirasi" required>
		</div>
		<div>
			<label class="mb-1 block text-sm font-medium text-slate-700">Lokasi</label>
			<input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Ruang D1" required>
		</div>
	</div>
	<div class="w-full">
		<textarea name="keterangan" id="keterangan" class="w-full h-32 rounded-sm border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500" placeholder="Keterangan aspirasi" required></textarea>
	</div>

	<div class="flex items-center gap-3">
		<button type="submit" class="inline-flex items-center rounded-sm bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
			<i class="fa-solid fa-floppy-disk w-4 text-center"></i>
			<span class="ml-2">Simpan</span>
		</button>
		<a href="{{ route('aspirasi.index') }}" class="inline-flex items-center rounded-sm border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
			Batal
		</a>
	</div>
</form>

@endsection