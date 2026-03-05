@extends('layouts.dashboard')
@section('title', 'Kelola Vendor')
@section('page-title', 'Manajemen Vendor')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div></div>
    <a href="{{ route('admin.vendors.create') }}" class="bg-gold-500 hover:bg-gold-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-luxury">
        + Tambah Vendor
    </a>
</div>

<div class="bg-white rounded-2xl shadow-card overflow-hidden border border-gold-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ivory-200 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Vendor</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Kontak</th>
                    <th class="px-6 py-3 text-left">Digunakan</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($vendors as $vendor)
                <tr class="hover:bg-ivory-100">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $vendor->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $vendor->category_label }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $vendor->phone ?? $vendor->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $vendor->vendor_assignments_count }} wedding</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $vendor->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $vendor->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.vendors.show', $vendor) }}" class="text-gold-600 hover:text-gold-700 text-xs font-medium">Detail</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="text-blue-600 hover:text-blue-700 text-xs font-medium">Edit</a>
                        <span class="text-gray-300">|</span>
                        <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST"
                              onsubmit="return confirm('Hapus vendor {{ $vendor->name }}?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada vendor.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">{{ $vendors->links() }}</div>
</div>
@endsection

