@extends('layouts.app')
@section('content')

<!-- Header daftar aspirasi -->
<div class="mb-4 w-full flex">
    <h2 class="text-lg font-semibold text-slate-900">Daftar Aspirasi</h2>

	@if (auth()->user()?->is_siswa)
		<a href="{{ route('aspirasi.create') }}" class="ml-auto inline-flex items-center rounded-sm bg-blue-500 px-3 py-2 text-sm font-medium text-white hover:bg-blue-600">
			<i class="fa-solid fa-plus w-4 text-center"></i>
			<span class="ml-1">Buat Aspirasi</span>
		</a>
	@endif
</div>

<div class="w-full overflow-x-auto rounded-sm border border-slate-200 bg-white">
	<!-- Tabel daftar aspirasi -->
	<table class="min-w-full divide-y divide-slate-200">
		<!-- Header tabel aspirasi -->
		<thead class="bg-slate-50">
			<tr>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Pengirim</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Judul</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Lokasi</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Keterangan</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Aksi</th>
			</tr>
		</thead>
		<!-- Isi tabel aspirasi -->
		<tbody class="divide-y divide-slate-200">
			@forelse ($aspirasis as $aspirasi)
				<tr class="hover:bg-slate-50">
					<td class="px-4 py-3 text-sm text-slate-800">{{ $aspirasi->siswa?->user?->nama ?? '-' }}</td>
					<td class="px-4 py-3 text-sm text-slate-800">
						<a class="font-medium text-slate-900 hover:underline" href="{{ route('aspirasi.show', $aspirasi) }}">
							{{ $aspirasi->judul ?? '-' }}
						</a>
					</td>
					<td class="px-4 py-3 text-sm text-slate-800">{{ $aspirasi->lokasi ?? '-' }}</td>
					<td class="px-4 py-3 text-sm text-slate-600">{{ $aspirasi->keterangan ?? '-' }}</td>
					<td class="px-4 py-3 text-sm">
						<a class="font-medium text-slate-900 hover:underline" href="{{ route('aspirasi.show', $aspirasi) }}">Detail</a>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada aspirasi.</td>
				</tr>
			@endforelse
		</tbody>
	</table>
</div>
@endsection