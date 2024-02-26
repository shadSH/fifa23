var swalInit = swal.mixin({
    buttonsStyling: false,
    confirmButtonClass: 'btn btn-outline-danger',
    cancelButtonClass: 'btn btn-light'
});




function warning_swal_alert(title , text , icon , confirmButtonText , route , id , request_type = 'DELETE' , token_csrf , table_name = '#info_table' , message = 'Record deleted successfully!' , type_notify = 'success' ){
    swalInit.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmButtonText
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.value === true) {
            send_ajax_request(request_type,token_csrf , route, id , message , type_notify,table_name )
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
}
