@extends('layouts.app')
@section('content')

<!-- Cek apakah pengguna saat ini adalah admin atau siswa -->
@php
$isAdmin = auth()->user()?->is_siswa === false;
$isSiswa = auth()->user()?->is_siswa === true;
@endphp

<!-- Header detail aspirasi -->
<div class="mb-6 flex items-center justify-between gap-4">
	<div>
		<h2 class="text-lg font-semibold text-slate-900">Detail Aspirasi</h2>
		<p class="mt-1 text-sm text-slate-600">Lihat aspirasi dan umpan balik terkait.</p>
	</div>
	<div class="flex items-center gap-3">
		<!-- Tombol untuk admin menuju ke halaman beri umpan balik -->
		@if ($isAdmin)
		<a href="{{ route('umpan-balik.create', ['aspirasi_id' => $aspirasis->id]) }}" class="rounded-sm bg-blue-500 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600">
			Beri Umpan Balik
		</a>
		@endif
		<a href="{{ route('aspirasi.index') }}" class="rounded-sm border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
			Kembali
		</a>
	</div>
</div>

<!-- Isi aspirasi -->
<div class="grid gap-4">
	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Judul</p>
		<p class="mt-2 text-sm text-slate-900">{{ $aspirasis->judul ?? '-' }}</p>
	</div>
	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Lokasi</p>
		<p class="mt-2 text-sm text-slate-900">{{ $aspirasis->lokasi ?? '-' }}</p>
	</div>
	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Keterangan</p>
		<p class="mt-2 whitespace-pre-wrap text-sm text-slate-900">{{ $aspirasis->keterangan ?? '-' }}</p>
	</div>
	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<div class="mb-4 flex items-center justify-between">
			<h3 class="text-base font-semibold text-slate-900">Umpan Balik</h3>
			<!-- Fungsi untuk menampilkan jumlah umpan balik -->
			<p class="text-sm text-slate-500">{{ $umpanBalik->count() }}</p>
		</div>

		<div class="w-full overflow-x-auto rounded-sm border border-slate-200 bg-white">
			<!-- Tabel untuk menampilkan umpan balik -->
			<table class="min-w-full divide-y divide-slate-200">
				<!-- Header tabel umpan balik -->
				<thead class="bg-slate-50">
					<tr>
						<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Pengirim</th>
						<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Status</th>
						<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Isi</th>
						<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Waktu</th>
					</tr>
				</thead>
				<!-- Isi tabel umpan balik -->
				<tbody class="divide-y divide-slate-200">
					@forelse ($umpanBalik as $item)
					<tr class="hover:bg-slate-50">
						<td class="px-4 py-3 text-sm text-slate-800">{{ $item->user?->nama ?? '-' }}</td>
						<td class="px-4 py-3 text-sm text-slate-800">{{ $item->status_penyelesaian ? ucfirst($item->status_penyelesaian) : '-' }}</td>
						<td class="px-4 py-3 text-sm text-slate-800">{{ $item->isi_umpan_balik }}</td>
						<td class="px-4 py-3 text-sm text-slate-600">{{ $item->created_at?->format('d M Y H:i') }}</td>
					</tr>
					@empty
					<tr>
						<td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada umpan balik untuk aspirasi ini.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>

	</div>
</div>

@endsection