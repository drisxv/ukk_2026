@extends('layouts.app')
@section('content')

<!-- Header daftar umpan balik -->
<div class="mb-6 flex items-center justify-between gap-4">
	<h2 class="text-lg font-semibold text-slate-900">Daftar Umpan Balik</h2>
	<a href="{{ route('umpan-balik.create') }}" class="rounded-sm bg-blue-500 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600">
		Tambah Umpan Balik
	</a>
</div>

<div class="w-full overflow-x-auto rounded-sm border border-slate-200 bg-white">
	<!-- Tabel daftar umpan balik -->
	<table class="min-w-full divide-y divide-slate-200">
		<!-- Header tabel umpan balik -->
		<thead class="bg-slate-50">
			<tr>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Pengirim</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Aspirasi</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Status</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Isi</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Waktu</th>
				<th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Aksi</th>
			</tr>
		</thead>
		<!-- Isi tabel umpan balik -->
		<tbody class="divide-y divide-slate-200">
			@forelse ($umpanBaliks as $umpanBalik)
				<tr class="hover:bg-slate-50">
					<td class="px-4 py-3 text-sm text-slate-800">{{ $umpanBalik->user?->nama ?? '-' }}</td>
					<td class="px-4 py-3 text-sm text-slate-800">{{ $umpanBalik->aspirasi?->judul ?? '-' }}</td>
					<td class="px-4 py-3 text-sm text-slate-800">{{ $umpanBalik->status_penyelesaian ? ucfirst($umpanBalik->status_penyelesaian) : '-' }}</td>
					<td class="px-4 py-3 text-sm text-slate-800">{{ $umpanBalik->isi_umpan_balik }}</td>
					<td class="px-4 py-3 text-sm text-slate-600">{{ $umpanBalik->created_at?->format('d M Y H:i') }}</td>
					<td class="px-4 py-3 text-sm">
						<a class="font-medium text-slate-900 hover:underline" href="{{ route('umpan-balik.show', $umpanBalik) }}">Detail</a>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada umpan balik.</td>
				</tr>
			@endforelse
		</tbody>
	</table>
</div>

<div class="mt-6">
	{{ $umpanBaliks->links() }}
</div>
@endsection