<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Tugas: {{ $tugas->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- KOTAK DETAIL TUGAS --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Deskripsi</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ $tugas->deskripsi }}
                    </p>

                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        <strong>Jenis Tugas:</strong> {{ ucwords(str_replace('_', ' ', $tugas->jenis)) }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <strong>Diberikan oleh:</strong> {{ $tugas->pembimbing->name }}
                    </p>
                </div>
            </div>

            {{-- KOTAK PENGUMPULAN TUGAS --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @if ($tugas->status == 'diberikan')
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Form Pengumpulan Tugas</h3>
                        <form method="POST" action="{{ route('peserta.tugas.submit', $tugas->id) }}"
                            class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            @if ($tugas->jenis == 'dokumen/proyek')
                                <div>
                                    <x-input-label for="file_laporan" value="Upload File Laporan (PDF, ZIP, DOCX)" />
                                    <input id="file_laporan" name="file_laporan" type="file"
                                        class="block w-full text-sm text-gray-500 mt-1 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100" />
                                    <x-input-error class="mt-2" :messages="$errors->get('file_laporan')" />
                                </div>
                            @elseif ($tugas->jenis == 'lapangan_teknis')
                                <div>
                                    <x-input-label for="laporan_deskripsi" value="Tulis Laporan Deskripsi" />
                                    <textarea id="laporan_deskripsi" name="laporan_deskripsi"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        rows="6">{{ old('laporan_deskripsi') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('laporan_deskripsi')" />
                                </div>
                            @endif

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Kumpulkan Tugas') }}</x-primary-button>
                            </div>
                        </form>
                    @else
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Status Tugas</h3>
                        <p class="mt-2 text-gray-800 dark:text-gray-200">
                            Anda telah mengumpulkan tugas ini pada tanggal
                            {{ \Carbon\Carbon::parse($tugas->tanggal_selesai)->format('d M Y') }}.
                        </p>
                        <p class="mt-1">Status saat ini: <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ ucfirst($tugas->status) }}</span>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
