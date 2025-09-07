<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Peserta Baru (Generator Otomatis)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('peserta.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap Peserta')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="institusi_asal" :value="__('Institusi Asal (Sekolah/Universitas)')" />
                            <x-text-input id="institusi_asal" class="block mt-1 w-full" type="text"
                                name="institusi_asal" :value="old('institusi_asal')" required />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="no_hp" :value="__('Nomor HP (Opsional)')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp"
                                :value="old('no_hp')" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan dan Generate Akun') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
