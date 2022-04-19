<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a href="{{ route('books.add') }}"
                   class="my-4 inline-flex justify-center float-right rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                    Kitap Ekle
                </a>
                <table class="table-fixed w-full" id="setting-default">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-40">Kitap Adı</th>
                            <th class="px-4 py-2">Kitap Resmi</th>
                            <th class="px-4 py-2">Sayfa Sayısı</th>
                            <th class="px-4 py-2">Kitap Türü</th>
                            <th class="px-4 py-2">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{!! asset('plugins/toastr/plugin.min.js') !!}"></script>
        <script src="{!! asset('plugins/datatables/plugin.min.js') !!}"></script>
        <script src="{!! asset('plugins/sweetalert2/plugin.min.js') !!}"></script>
        @if (session()->has('message'))
            <script>
                toastr.info("{{ session('message') }}");
            </script>
        @endif
        <script>
            let dataUrl = "{!! route('books.data') !!}";
            let datatable = null;
            $(document).ready(function() {
                setTimeout(function() {
                    datatable = $('#setting-default').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        language: datatablesLang,
                        ajax: dataUrl,
                        searching: true,
                        columns: [
                            {data: 'title', name: 'title'},
                            {data: 'image_html', name: 'image_html', orderable: false, searchable: false, "render": function ( data ) {return htmldecode(data);}},
                            {data: 'total_pages', name: 'total_pages', orderable: false, searchable: false},
                            {data: 'audio_book_text', name: 'audio_book_text', orderable: false, searchable: false},
                            {data: 'actions', name: 'actions', orderable: false, searchable: false, "render": function ( data ) {return htmldecode(data);}},
                        ],
                        order: [[0, 'asc']]
                    });
                    makeDeleteBtn();
                }, 350);
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{!! asset('plugins/toastr/plugin.min.css') !!}">
        <link rel="stylesheet" href="{!! asset('plugins/datatables/plugin.min.css') !!}">
    @endpush
</x-app-layout>
