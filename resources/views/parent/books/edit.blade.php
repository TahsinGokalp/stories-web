<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <form method="post" enctype="multipart/form-data" action="{!! route('books.update', $edit->id) !!}">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="">
                            <div class="mb-4">
                                <label for="title"
                                       class="block text-gray-700 text-sm font-bold mb-2">Kitap Adı</label>
                                <input type="text"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       id="title" placeholder="Kitap Adı" name="title" value="{{ $edit->title }}">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="cover"
                                       class="block text-gray-700 text-sm font-bold mb-2">Kitap Resmi</label>
                                <input type="file"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       id="cover" name="cover">
                                @error('cover') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="audio_book"
                                       class="block text-gray-700 text-sm font-bold mb-2">Kitap Türü</label>
                                <select id="audio_book" name="audio_book" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option @selected(old('audio_book', $edit) == 0) value="0">Kitap</option>
                                    <option @selected(old('audio_book', $edit) == 1) value="1">Sesli Kitap</option>
                                </select>
                                @error('audio_book') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="submit"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Kaydet
                            </button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <a href="{{ route('books') }}"
                               class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Geri Dön
                            </a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
