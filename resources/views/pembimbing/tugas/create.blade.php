<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Tugas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('pembimbing.tugas.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="judul" value="Judul Tugas" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul"
                                :value="old('judul')" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="deskripsi" value="Deskripsi Tugas" />
                            <textarea id="deskripsi" name="deskripsi"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="peserta_ids" value="Tugaskan Kepada (Bisa Pilih Lebih dari Satu)" />
                            <select name="peserta_ids[]" id="peserta_ids" multiple
                                class="block mt-1 w-full border-gray-300 ...">
                                {{-- Tahan Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu --}}
                                @foreach ($pesertas as $peserta)
                                    <option value="{{ $peserta->user_id }}">{{ $peserta->user->name }}
                                        ({{ $peserta->nim_nisn }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label value="Jenis Tugas" />
                            <div class="mt-2 space-y-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis" value="dokumen/proyek"
                                        class="text-indigo-600 border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500">
                                    <span class="ml-2">Dokumen / Proyek (Upload File)</span>
                                </label>
                                <br>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis" value="lapangan_teknis"
                                        class="text-indigo-600 border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500">
                                    <span class="ml-2">Lapangan Teknis (Laporan Teks)</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan Tugas') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
