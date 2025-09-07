<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Peserta: ') . $peserta->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('peserta.update', $peserta->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap"
                                :value="old('nama_lengkap', $peserta->nama_lengkap)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_lengkap')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="institusi_asal" :value="__('Institusi Asal (Sekolah/Universitas)')" />
                            <x-text-input id="institusi_asal" class="block mt-1 w-full" type="text"
                                name="institusi_asal" :value="old('institusi_asal', $peserta->institusi_asal)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('institusi_asal')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="no_hp" :value="__('Nomor HP')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp"
                                :value="old('no_hp', $peserta->no_hp)" />
                            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
                        </div>

                        {{-- Tambah Pilihan Status --}}
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status Magang')" />
                            <select name="status" id="status"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="Aktif" @selected(old('status', $peserta->status) == 'Aktif')>Aktif</option>
                                <option value="Selesai" @selected(old('status', $peserta->status) == 'Selesai')>Selesai</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <div class="mt-4">
                            <x-input-label for="nim_nisn" :value="__('NIM/NISN')" />
                            <x-text-input id="nim_nisn" class="block mt-1 w-full" type="text" name="nim_nisn"
                                :value="old('nim_nisn', $peserta->nim_nisn)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nim_nisn')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="jurusan" :value="__('Jurusan')" />
                            <x-text-input id="jurusan" class="block mt-1 w-full" type="text" name="jurusan"
                                :value="old('jurusan', $peserta->jurusan)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('jurusan')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                            <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date"
                                name="tanggal_mulai" :value="old('tanggal_mulai', $peserta->tanggal_mulai)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_mulai')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="tanggal_berakhir" :value="__('Tanggal Berakhir')" />
                            <x-text-input id="tanggal_berakhir" class="block mt-1 w-full" type="date"
                                name="tanggal_berakhir" :value="old('tanggal_berakhir', $peserta->tanggal_berakhir)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_berakhir')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
