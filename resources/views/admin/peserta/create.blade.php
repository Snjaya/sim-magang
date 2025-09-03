{{-- resources/views/admin/Peserta/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Intern Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 space-y-6">
                    {{-- Tampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <ul class="list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('peserta.store') }}">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-900">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                autofocus
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 bg-white placeholder-gray-500"
                                placeholder="Masukkan nama lengkap" />
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 bg-white placeholder-gray-500"
                                placeholder="Masukkan alamat email" />
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                            <input type="password" id="password" name="password" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 bg-white placeholder-gray-500"
                                placeholder="Masukkan password" />
                        </div>

                        <!-- NIM/NISN -->
                        <div class="space-y-2">
                            <label for="nim_nisn" class="block text-sm font-medium text-gray-900">NIM/NISN</label>
                            <input type="text" id="nim_nisn" name="nim_nisn" value="{{ old('nim_nisn') }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 bg-white placeholder-gray-500"
                                placeholder="Masukkan NIM atau NISN" />
                        </div>

                        <!-- Jurusan -->
                        <div class="space-y-2">
                            <label for="jurusan" class="block text-sm font-medium text-gray-900">Jurusan</label>
                            <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 bg-white placeholder-gray-500"
                                placeholder="Masukkan jurusan" />
                        </div>

                        <!-- Asal Sekolah/Kampus -->
                        <div class="space-y-2">
                            <label for="asal_sekolah_kampus" class="block text-sm font-medium text-gray-900">Asal
                                Sekolah/Kampus</label>
                            <input type="text" id="asal_sekolah_kampus" name="asal_sekolah_kampus"
                                value="{{ old('asal_sekolah_kampus') }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 bg-white placeholder-gray-500"
                                placeholder="Masukkan asal sekolah atau kampus" />
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="space-y-2">
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-900">Tanggal
                                Mulai</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai') }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 bg-white" />
                        </div>

                        <!-- Tanggal Berakhir -->
                        <div class="space-y-2">
                            <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-900">Tanggal
                                Berakhir</label>
                            <input type="date" id="tanggal_berakhir" name="tanggal_berakhir"
                                value="{{ old('tanggal_berakhir') }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 bg-white" />
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end mt-8">
                            <button type="submit"
                                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
