{{-- resources/views/admin/pembimbing/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pembimbing.update', $pembimbing->id) }}">
                        @csrf
                        @method('PUT') {{-- PENTING: Method untuk update adalah PUT/PATCH --}}

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $pembimbing->user->name)" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email', $pembimbing->user->email)" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="nip" :value="__('NIP')" />
                            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip"
                                :value="old('nip', $pembimbing->nip)" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="jabatan" :value="__('Jabatan')" />
                            <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan"
                                :value="old('jabatan', $pembimbing->jabatan)" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password (Opsional)')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
