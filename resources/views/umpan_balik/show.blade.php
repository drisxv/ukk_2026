@extends('layouts.app')
@section('content')

<!-- Header detail umpan balik, tombol kembali -->
<div class="mb-6 flex items-center justify-between gap-4">
	<div>
		<h2 class="text-lg font-semibold text-slate-900">Detail Umpan Balik</h2>
		<p class="mt-1 text-sm text-slate-600">Informasi lengkap umpan balik.</p>
	</div>
	<a href="{{ route('umpan-balik.index') }}" class="rounded-sm border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
		Kembali
	</a>
</div>

<!-- Informasi umpan balik -->
<div class="grid gap-4">
	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Pengirim</p>
		<p class="mt-2 text-sm text-slate-900">{{ $umpanBalik->user?->nama ?? '-' }}</p>
	</div>

	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Aspirasi</p>
		<p class="mt-2 text-sm text-slate-900">
			{{ $umpanBalik->aspirasi?->judul ?? '-' }}
			@if ($umpanBalik->aspirasi?->lokasi)
				<span class="text-slate-500">— {{ $umpanBalik->aspirasi->lokasi }}</span>
			@endif
		</p>
	</div>

	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status Penyelesaian</p>
		<p class="mt-2 text-sm text-slate-900">{{ $umpanBalik->status_penyelesaian ? ucfirst($umpanBalik->status_penyelesaian) : '-' }}</p>
	</div>

	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Isi</p>
		<p class="mt-2 whitespace-pre-wrap text-sm text-slate-900">{{ $umpanBalik->isi_umpan_balik }}</p>
	</div>

	<div class="rounded-sm border border-slate-200 bg-white p-5">
		<p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Waktu</p>
		<p class="mt-2 text-sm text-slate-900">{{ $umpanBalik->created_at?->format('d M Y H:i') ?? '-' }}</p>
	</div>
</div>

@endsection
