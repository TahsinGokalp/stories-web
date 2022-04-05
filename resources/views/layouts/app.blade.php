<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            let lang = '{!! app()->getLocale() !!}';
            let localization = {
                whoops : '{!! __('Whoops, something went wrong on our servers.') !!}',
                sweetalert2: {
                    title: '{!! __('Confirmation') !!}',
                    text: '{!! __('Are you sure you want to delete?') !!}',
                    delete: '{!! __('Delete') !!}',
                    cancel: '{!! __('Cancel') !!}',
                }
            }
        </script>

        <script>
            function makeDeleteBtn(body = {}, container = null, selector = null, title = null, text = null, deleteText = null, cancel = null, redirect = null, refresh = false){
                if(container == null){
                    container = 'body';
                }
                if(selector == null){
                    selector = '.delete-btn';
                }
                if(title == null){
                    title = localization.sweetalert2.title;
                }
                if(text == null){
                    text = localization.sweetalert2.text
                }
                if(deleteText == null){
                    deleteText = localization.sweetalert2.delete;
                }
                if(cancel == null){
                    cancel = localization.sweetalert2.cancel;
                }
                return $(container).on('click', selector, function (event){
                    let url = $(this).attr('href');
                    event.preventDefault();
                    Swal.fire({
                        title: title,
                        text: text,
                        showCancelButton: true,
                        confirmButtonText: deleteText,
                        showLoaderOnConfirm: true,
                        cancelButtonText: cancel,
                        preConfirm: () => {
                            return fetch(url, {
                                method: "post",
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    "X-CSRF-Token": $('input[name="_token"]').val()
                                },
                                body: JSON.stringify(body)
                            }).then(response => {
                                if(!response.status) {
                                    throw new Error(response.message);
                                }
                                return response.json()
                            }).catch(error => {
                                Swal.showValidationMessage(
                                    localization.whoops
                                );
                            }).then((result) => {
                                if(result.status == 'ERROR'){
                                    toastr.error(result.message);
                                    return;
                                }
                                if(refresh){
                                    window.location.reload();
                                }else{
                                    if(redirect == null){
                                        datatable.ajax.reload();
                                        toastr.success("İşlem tamamlandı.")
                                    }else{
                                        window.location = redirect;
                                    }
                                }
                            });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                });
            }
        </script>

        <script>
            $(document).ready(function() {
                makeDeleteBtn();
            });
        </script>

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
