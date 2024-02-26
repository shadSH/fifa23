

function createSelect2Modal(selectors){
    selectors.forEach(function(selector) {
        $(selector).select2({
            dropdownParent: $('#modal_form_vertical')
        });
    });
}

function initializeDataTable(tableSelector, route, columns) {
    $(tableSelector).DataTable({
        processing: true,
        "order": [[0, "desc"]],
        serverSide: true,
        ajax: {
            url: route
        },
        columns: columns
    });
}

function editHandler(baseUrl , isPreviewImage = false){
    $(document).on("click", "#edit", function () {
        var id = $(this).data('id');
        $.ajax({
            url: baseUrl + "/" + id + '/edit',
            type: "GET",
            dataType: "json",
            success: function (data) {
                $(".update_section").html(data.html);
                if(isPreviewImage)
                {
                    AIZ.uploader.previewGenerate();
                }

                $("#modal_form_vertical_edit").modal("show");
            }
        });
    })
}

function error_validation(data){
    if( data.status === 422 ) {
        var errors = $.parseJSON(data.responseText);
        $.each(errors, function (key, value) {
            $('#response').addClass("alert alert-danger");

            if ($.isPlainObject(value)) {
                $.each(value, function (key, value) {
                    console.log(key + " " + value);
                    $('#response').show().append(value + "<br/>");
                    console.log(value)
                    new Noty({
                        text: value,
                        type: 'error'
                    }).show();
                });


            } else {
                $('#response').show().append(value + "<br/>"); //this is my div with messages
            }
        });

    }else if(data.status == 403)
    {
        new Noty({
            text: 'Please Login With A Specific Role',
            type: 'error'
        }).show();
    }else if(data.status == 404){
        new Noty({
            text: 'This Page Not Found',
            type: 'error'
        }).show();
    }else{
        new Noty({
            text: 'Something went wrong',
            type: 'error'
        }).show();
    }
}


function before_send(){
    $(document).find('span.error-text').text('');
    $('.submit_form').addClass('disabled');
    $('.send_icon').removeClass('icon-paperplane');
    $('.send_icon').addClass('ph-spinner spinner');
}



function complete_send(){
    $('.submit_form').removeClass('disabled');
    $('.send_icon').removeClass('ph-spinner spinner');
    $('.send_icon').addClass('icon-paperplane');
}

function before_send_loader(){
    $('.btn_filter').addClass('disabled');
    $('.icon_filter').removeClass('fa fa-search');
    $('.icon_filter').addClass('ph-spinner spinner');
    $('#loading').show();
}

function complete_send_loader(){
    $('.btn_filter').removeClass('disabled');
    $('.icon_filter').removeClass('ph-spinner spinner');
    $('.icon_filter').addClass('fa fa-search');
    $('#loading').hide();
}
function  success_send(data , modal_name , table_name , JjqXHR){
    if (JjqXHR.status === 200) {
        new Noty({
            text: data.message,
            type: 'success'
        }).show();
        $(modal_name).modal('hide');
        $(table_name).DataTable().ajax.reload();
    }
}


function send_ajax_request_form(form_data , modal_name = '#modal_form_vertical' , table_name = '#info_table'){
    $.ajax({
        url: $(form_data).attr('action'),
        method: $(form_data).attr('method'),
        data: new FormData(form_data),
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function () {
            before_send();
        },
        complete: function () {
            complete_send();
        },
        error: function (data, textStatus, errorThrown) {
            error_validation(data)
        },
        success: function (data, textStatus, jqXHR , message= "") {
            success_send(data , modal_name , table_name , jqXHR , message);
        }
    });
}

function send_ajax_request(request_type , token_csrf ,route , id , message = 'Success' , type_notify = 'success' , table_name = '#info_table' , show_notify = false , show_notify_value = ''){
    $.ajax({
        type: request_type,
        url: route,
        data: {
            "_token": token_csrf,
            id: id
        },
        error: function (data, textStatus, errorThrown) {
            error_validation(data)
        },
        success: function (response , textStatus , jqXHR) {

            if (jqXHR.status === 200) {
                new Noty({
                    text: response.message,
                    type: type_notify
                }).show();
                if(table_name !== ''){
                    $(table_name).DataTable().ajax.reload();
                }

                if(show_notify === true)
                {
                    swalInit.fire({
                        icon: 'success',
                        html: 'New Password is <strong>'+response.data.password+'</strong>',
                    });
                }

            }
        }
    });
}

function send_ajax_request_view_return(request_type, route, data = {}, view_return = '#view_return', callback = function(){}) {
    $.ajax({
        type: request_type,
        url: route,
        data: data,  // Added this line
        error: function (data, textStatus, errorThrown) {
            error_validation(data);
        },
        beforeSend: function () {
            before_send_loader();
        },
        complete: function () {
            complete_send_loader();
        },
        success: function (response, textStatus, jqXHR) {
            $(view_return).html(response.html);
            // callback(response);  // Added this line
        }
    });
}


function send_ajax_request_with_data(request_type ,route ,   data = {} , table_name = '#info_table' , message = 'Success' , type_notify = 'success' ){
    $.ajax({
        type: request_type,
        url: route,
        data: data,  // Added this line
        error: function (data, textStatus, errorThrown) {
            error_validation(data)
        }, beforeSend: function () {
            before_send_loader();
        },
        complete: function () {
            complete_send_loader();
        },
        success: function (response , textStatus , jqXHR) {

            if (jqXHR.status === 200) {
                new Noty({
                    text: response.message,
                    type: type_notify
                }).show();
                if(table_name !== ''){
                    $(table_name).DataTable().ajax.reload();
                }

            }
        }
    });
}

function trigger_and_showing_modal(form_name ='#main_form' , modal_name = '#modal_form_vertical'){
    $(document).off('focusin.modal');
    $(form_name).trigger("reset");
    $('select').trigger('change');
    $(modal_name).modal('show');
}

function timeAgo(date) {
    let now = new Date();
    let secondsPast = (now.getTime() - date.getTime()) / 1000;
    if(secondsPast < 60){
        return parseInt(secondsPast) + ' seconds ago';
    }
    if(secondsPast < 3600){
        return parseInt(secondsPast/60) + ' minutes ago';
    }
    if(secondsPast <= 86400){
        return parseInt(secondsPast/3600) + ' hours ago';
    }
    if(secondsPast > 86400){
        let day = date.getDate();
        let month = date.toDateString().match(/ [a-zA-Z]*/)[0].replace(" ","");
        let year = date.getFullYear() == now.getFullYear() ? "" :  " "+date.getFullYear();
        return day + " " + month + year;
    }
}
