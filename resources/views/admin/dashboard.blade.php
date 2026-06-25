<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin (Dosen)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Pengajuan Magang Mahasiswa</h3>
                    
                    <table class="min-w-full bg-white border border-gray-300 mt-4">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">Nama Mahasiswa</th>
                                <th class="py-2 px-4 border-b text-left">Perusahaan</th>
                                <th class="py-2 px-4 border-b text-left">Tanggal</th>
                                <th class="py-2 px-4 border-b text-left">Status</th>
                                <th class="py-2 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($internships as $magang)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $magang->user->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    <strong>{{ $magang->company_name }}</strong><br>
                                    <span class="text-sm text-gray-500">{{ $magang->position }}</span>
                                </td>
                                <td class="py-2 px-4 border-b text-sm">
                                    {{ $magang->start_date }} <br>s/d<br> {{ $magang->end_date }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    @if($magang->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-bold">Menunggu</span>
                                    @elseif($magang->status === 'approved')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-bold">Disetujui</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-bold">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    @if($magang->status === 'pending')
                                        <div class="flex justify-center space-x-2">
                                            <!-- Tombol Setujui -->
                                            <form action="{{ route('admin.internship.updateStatus', $magang->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">Setujui</button>
                                            </form>
                                            
                                            <!-- Tombol Tolak -->
                                            <form action="{{ route('admin.internship.updateStatus', $magang->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Tolak</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">Belum ada mahasiswa yang mendaftar magang.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>