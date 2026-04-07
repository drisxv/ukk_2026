@extends('layouts.app')
@section('content')

<!-- Header tambah umpan balik, dan tombol kembali -->
<div class="mb-6 flex items-center justify-between gap-4">
	<div>
		<h2 class="text-lg font-semibold text-slate-900">Tambah Umpan Balik</h2>
		<p class="mt-1 text-sm text-slate-600">Kirim umpan balik untuk aspirasi yang dipilih.</p>
	</div>
	<a href="{{ route('umpan-balik.index') }}" class="rounded-sm border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
		Kembali
	</a>
</div>

<!-- Formulir tambah umpan balik -->
<form method="POST" action="{{ route('umpan-balik.store') }}" class="space-y-5">
	@csrf
	<div>
		<label for="aspirasi_id" class="mb-2 block text-sm font-semibold text-slate-700">Aspirasi</label>
		<!-- tampilan dropdown aspirasi -->
		@php
			$selectedAspirasiId = old('aspirasi_id', request('aspirasi_id'));
		@endphp
		<select id="aspirasi_id" name="aspirasi_id" class="w-full rounded-sm border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900">
			<option value="" disabled {{ $selectedAspirasiId ? '' : 'selected' }}>Pilih aspirasi</option>
			@foreach ($aspirasis as $aspirasi)
				<option value="{{ $aspirasi->id }}" {{ (string) $selectedAspirasiId === (string) $aspirasi->id ? 'selected' : '' }}>
					#{{ $aspirasi->id }} — {{ $aspirasi->judul }} ({{ $aspirasi->lokasi }})
				</option>
			@endforeach
		</select>
		@if ($aspirasis->isEmpty())
			<p class="mt-2 text-sm text-slate-500">Belum ada aspirasi yang bisa diberi umpan balik.</p>
		@endif
	</div>

	<div>
		<label for="isi_umpan_balik" class="mb-2 block text-sm font-semibold text-slate-700">Isi Umpan Balik</label>
		<textarea id="isi_umpan_balik" name="isi_umpan_balik" rows="5" class="w-full rounded-sm border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900" placeholder="Tulis umpan balik...">{{ old('isi_umpan_balik') }}</textarea>
	</div>

	<div>
		<label for="status_penyelesaian" class="mb-2 block text-sm font-semibold text-slate-700">Status Penyelesaian</label>
		<select id="status_penyelesaian" name="status_penyelesaian" class="w-full rounded-sm border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900">
			@php
				$status = old('status_penyelesaian', 'pending');
			@endphp
			<option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
			<option value="proses" {{ $status === 'proses' ? 'selected' : '' }}>Proses</option>
			<option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
		</select>
	</div>

	<div class="flex items-center gap-3">
		<button type="submit" class="rounded-sm bg-blue-500 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600">
			Kirim
		</button>
		<a href="{{ route('umpan-balik.index') }}" class="rounded-sm border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
			Batal
		</a>
	</div>
</form>

@endsection
