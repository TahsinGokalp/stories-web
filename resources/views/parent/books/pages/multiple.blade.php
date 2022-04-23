<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <form method="post" enctype="multipart/form-data" class="dropzone" action="{!! route('books.page.save.multiple', $bookId) !!}" id="page-dropzone">
                    @csrf
                </form>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <a href="{{ route('books.page', $bookId) }}"
                               class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Geri Dön
                            </a>
                        </span>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{!! asset('plugins/dropzone/plugin.min.js') !!}"></script>
        <script>
            Dropzone.options.pageDropzone = {
                parallelUploads: 1,
            };
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{!! asset('plugins/dropzone/plugin.min.css') !!}">
    @endpush
</x-app-layout>
