{{-- resources/views/admin/Peserta/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah Data Intern Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Tampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('peserta.store') }}">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')"
                                class="block text-sm font-medium text-gray-800" />
                            <x-text-input id="name"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white placeholder-gray-500"
                                type="text" name="name" :value="old('name')" required autofocus
                                placeholder="Masukkan nama lengkap" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')"
                                class="block text-sm font-medium text-gray-800" />
                            <x-text-input id="email"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white placeholder-gray-500"
                                type="email" name="email" :value="old('email')" required
                                placeholder="Masukkan alamat email" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')"
                                class="block text-sm font-medium text-gray-800" />
                            <x-text-input id="password"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white placeholder-gray-500"
                                type="password" name="password" required placeholder="Masukkan password" />
                        </div>

                        <!-- NIM/NISN -->
                        <div class="mt-4">
                            <x-input-label for="nim_nisn" :value="__('NIM/NISN')"
                                class="block text-sm font-medium text-gray-800" />
                            <x-text-input id="nim_nisn"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white placeholder-gray-500"
                                type="text" name="nim_nisn" :value="old('nim_nisn')" required
                                placeholder="Masukkan NIM atau NISN" />
                        </div>

                        <!-- Jurusan -->
                        <div class="mt-4">
                            <x-input-label for="jurusan" :value="__('Jurusan')"
                                class="block text-sm font-medium text-gray-800" />
                            <x-text-input id="jurusan"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white placeholder-gray-500"
                                type="text" name="jurusan" :value="old('jurusan')" required
                                placeholder="Masukkan jurusan" />
                        </div>

                        <!-- Asal Sekolah/Kampus -->
                        <div class="mt-4">
                            <x-input-label for="asal_sekolah_kampus" :value="__('Asal Sekolah/Kampus')"
                                class="block text-sm font-medium text-gray-800" />
                            <x-text-input id="asal_sekolah_kampus"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white placeholder-gray-500"
                                type="text" name="asal_sekolah_kampus" :value="old('asal_sekolah_kampus')" required
                                placeholder="Masukkan asal sekolah atau kampus" />
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="mt-4">
                            <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')"
                                class="block text-sm font-medium text-gray-800" />
                            <x-text-input id="tanggal_mulai"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white"
                                type="date" name="tanggal_mulai" :value="old('tanggal_mulai')" required />
                        </div>

                        <!-- Tanggal Berakhir -->
                        <div class="mt-4">
                            <x-input-label for="tanggal_berakhir" :value="__('Tanggal Berakhir')"
                                class="block text-sm font-medium text-gray-800" />
                            <x-text-input id="tanggal_berakhir"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white"
                                type="date" name="tanggal_berakhir" :value="old('tanggal_berakhir')" required />
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
