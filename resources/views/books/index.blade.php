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
                <a href="{{ route('books.add') }}"
                        class="my-4 inline-flex justify-center float-right rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                    Kitap Ekle
                </a>
                <table class="table-fixed w-full">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-40">Kitap Adı</th>
                        <th class="px-4 py-2">Kitap Resmi</th>
                        <th class="px-4 py-2">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td class="border px-4 py-2">{{ $book->title }}</td>
                            <td class="border px-4 py-2">
                                <img src="https://mdbootstrap.com/img/new/standard/city/047.jpg" class="max-w-full h-auto rounded-lg" alt="">
                                {{ $book->cover }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('books.edit', $book->id) }}"
                                   class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">
                                    Düzenle
                                </a>
                                <a href="{{ route('books.add') }}"
                                   class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">
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
