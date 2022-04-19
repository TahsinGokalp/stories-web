function makeDatatable(url, type = 'GET', data = {}, searching = true, ordering = true){
    return $('#setting-default').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": url,
            "type": type,
            "data": data,
        },
        "searching": searching,
        "ordering": ordering,
        "responsive": true,
        "language": datatablesLang,
    });
}

function makeHtmlDatatable(selector){
    return $(selector).DataTable({
        "language": datatablesLang,
        "responsive": true,
    });
}
