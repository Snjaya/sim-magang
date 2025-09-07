<x-app-layout>
    {{-- Tambahkan script Alpine.js di head untuk fungsionalitas modal --}}
    <x-slot name="header_scripts">
        <script src="//unpkg.com/alpinejs" defer></script>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Data Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, pdfUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                        <a href="{{ route('peserta.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mb-4 sm:mb-0">
                            + Tambah Peserta
                        </a>
                        {{-- Fitur Pencarian (Opsional, bisa dikembangkan nanti) --}}
                        <input type="text" placeholder="Cari peserta..."
                            class="w-full sm:w-64 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 flex justify-between items-center"
                            role="alert">
                            <div>
                                <p class="font-bold">Sukses!</p>
                                <p>{{ session('success') }}</p>
                            </div>
                            @if (session('pesertaBaruId'))
                                {{-- Tombol ini sekarang memicu modal --}}
                                <button
                                    @click="showModal = true; pdfUrl = '{{ route('peserta.cetakKartu', session('pesertaBaruId')) }}'"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Lihat Kartu Akun
                                </button>
                            @endif
                        </div>
                    @endif

                    {{-- Tampilan Card Responsif --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($pesertas as $peserta)
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 p-5 rounded-lg shadow-md flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 truncate">
                                        {{ $peserta->nama_lengkap }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                        {{ $peserta->institusi_asal }}</p>
                                    <div class="space-y-2 text-sm">
                                        <p><strong
                                                class="font-medium text-gray-600 dark:text-gray-300">Username:</strong>
                                            <code
                                                class="bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">{{ $peserta->user->name }}</code>
                                        </p>
                                        <p><strong class="font-medium text-gray-600 dark:text-gray-300">Email
                                                Login:</strong> <span
                                                class="text-gray-700 dark:text-gray-300">{{ $peserta->user->email }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="border-t border-gray-200 dark:border-gray-600 mt-4 pt-4 flex justify-between items-center">
                                    {{-- Tombol Lihat Kartu untuk setiap peserta --}}
                                    <button
                                        @click="showModal = true; pdfUrl = '{{ route('peserta.cetakKartu', $peserta->id) }}'"
                                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Lihat
                                        Kartu</button>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('peserta.edit', $peserta->id) }}"
                                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Edit</a>
                                        <form class="inline-block"
                                            action="{{ route('peserta.destroy', $peserta->id) }}" method="POST"
                                            onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm text-red-600 dark:text-red-400 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="md:col-span-2 lg:col-span-3 text-center text-gray-500 py-10">Data Peserta masih
                                kosong.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>

        <div x-show="showModal" @keydown.escape.window="showModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div @click.away="showModal = false"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-1/2 h-5/6 flex flex-col">
                <div class="flex justify-between items-center p-4 border-b dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pratinjau Kartu Akun</h3>
                    <button @click="showModal = false"
                        class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-200">&times;</button>
                </div>
                <div class="flex-grow p-4">
                    <iframe :src="pdfUrl" class="w-full h-full border-0"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
