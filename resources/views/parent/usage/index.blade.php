<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <strong>Resim Dosyaları : </strong><span>{{ $usage['images'] }} MB</span><br />
                <strong>Ses Dosyaları : </strong><span>{{ $usage['sound'] }} MB</span>
            </div>
        </div>
    </div>
</x-app-layout>
