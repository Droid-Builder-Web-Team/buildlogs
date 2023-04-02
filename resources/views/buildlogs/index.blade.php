<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Build Logs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-screen-2xl mx-auto sm:px-4 lg:px-6">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-6">
                <button onclick="location.href='{{ route('buildlogs.create') }}'" type="button">Make Build Log</button>
            </div>
            <livewire:build-log-table/>
        </div>
        
    </div>
</x-app-layout>