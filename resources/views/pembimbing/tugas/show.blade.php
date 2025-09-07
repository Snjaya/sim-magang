<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Review Tugas: {{ $tugas->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Detail Tugas</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $tugas->deskripsi }}</p>
                    <p class="mt-4 text-sm"><strong>Dikerjakan oleh:</strong>
                        @foreach ($tugas->pesertas as $peserta)
                            <span class="block ml-4">- {{ $peserta->name }}</span>
                        @endforeach
                    </p>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Hasil Pekerjaan Peserta</h3>

                    @if ($tugas->status == 'verifikasi')
                        @if ($tugas->jenis == 'dokumen/proyek')
                            <p class="mt-2">Peserta telah mengunggah sebuah file. Silakan unduh untuk diperiksa.</p>
                            <a href="{{ asset('storage/' . $tugas->file_path) }}" target="_blank"
                                class="inline-block mt-4 text-indigo-600 dark:text-indigo-400 hover:underline">
                                ⬇️ Download File Laporan
                            </a>
                        @elseif($tugas->jenis == 'lapangan_teknis')
                            <p class="mt-2">Berikut adalah laporan yang ditulis oleh peserta:</p>
                            <div
                                class="mt-4 p-4 border border-gray-200 dark:border-gray-700 rounded-md bg-gray-50 dark:bg-gray-900 whitespace-pre-wrap">
                                {{ $tugas->laporan_deskripsi }}</div>
                        @endif

                        {{-- FORM AKSI VERIFIKASI --}}
                        <form method="POST" action="{{ route('pembimbing.tugas.verify', $tugas->id) }}"
                            class="mt-6 flex items-center space-x-4">
                            @csrf
                            @method('PATCH')

                            <x-primary-button name="status" value="selesai">
                                ✅ Setujui (Selesai)
                            </x-primary-button>

                            <x-secondary-button name="status" value="revisi">
                                ❌ Minta Revisi
                            </x-secondary-button>
                        </form>
                    @else
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Tugas ini belum dikumpulkan atau sudah
                            selesai diverifikasi.</p>
                        <p class="mt-1">Status saat ini: <strong>{{ ucfirst($tugas->status) }}</strong></p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
