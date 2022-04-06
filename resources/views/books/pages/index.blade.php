<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                         role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('books.page.add', $bookId) }}"
                        class="my-4 inline-flex justify-center float-right rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                    Sayfa Ekle
                </a>
                <table class="table-fixed w-full">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-40">Sıra</th>
                        <th class="px-4 py-2">Sayfa Resmi</th>
                        <th class="px-4 py-2">Ses</th>
                        <th class="px-4 py-2">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td class="border px-4 py-2">{{ $page->page_order }}</td>
                            <td class="border px-4 py-2">
                                <img src="{{ route('books.page.serve', [$bookId, $page->id]) }}" class="max-w-full h-auto rounded-lg" alt="">
                            </td>
                            <td class="border px-4 py-2">
                                @if($page->sound === null)
                                    Yok
                                @else
                                    Var
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('books.page.edit', [$bookId, $page->id]) }}"
                                   class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">
                                    Düzenle
                                </a>
                                <a href="{{ route('books.page.delete', [$bookId, $page->id]) }}"
                                   class="delete-btn my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">
                                    Sil
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
