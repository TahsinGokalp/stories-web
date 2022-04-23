<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a href="{{ route('books.page.add.multiple', $bookId) }}"
                   class="my-4 inline-flex justify-center float-right rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                    Çoklu Sayfa Ekle
                </a>
                <a href="{{ route('books.page.add', $bookId) }}"
                        class="my-4 inline-flex justify-center mr-2 float-right rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                    Sayfa Ekle
                </a>
                <table class="table-fixed w-full" id="setting-default" aria-describedby="Kitap Sayfaları">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-40">Sıra</th>
                        <th class="px-4 py-2">Sayfa Resmi</th>
                        <th class="px-4 py-2">Ses</th>
                        <th class="px-4 py-2">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
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
            let dataUrl = "{!! route('books.page.data', $bookId) !!}";
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
                            {data: 'page_order', name: 'page_order'},
                            {data: 'image_html', name: 'image_html', orderable: false, searchable: false, "render": function ( data ) {return htmldecode(data);}},
                            {data: 'sound', name: 'sound', orderable: false, searchable: false, "render": function ( data ) {return (data === null) ? 'Yok' : 'Var';}},
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
