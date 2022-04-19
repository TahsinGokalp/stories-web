function makeDeleteBtn(body = {}, container = null, selector = null, title = null, text = null, deleteText = null, cancel = null, redirect = null, refresh = false){
    if(container == null){
        container = '#setting-default';
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
