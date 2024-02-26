
<script>
    $(document).ready(function () {
        $("#info_table").DataTable({
            processing: true,
            // "order": [[0, "desc"]],
            serverSide: true,
            "pageLength": 12,
            columnDefs: [{
                targets: [ 0 ]
            }],
            ajax: {
                url: "{{route('uploaded-files.data')}}"
            },
            columns: [
                {
                    data: "image",
                    name: "image"
                },
            ]
        });
    })
    function detailsInfo(e){
        $('#info-modal-content').html('<div class="c-preloader text-center absolute-center"><i class="las la-spinner la-spin la-3x opacity-70"></i></div>');
        var id = $(e).data('id')
        $('#info-modal').modal('show');
        $.post('{{ route('uploaded-files.info') }}', {_token: "{{csrf_token()}}", id:id}, function(data){
            $('#info-modal-content').html(data);
            // console.log(data);
        });
    }
    function copyUrl(e) {
        var url = $(e).data('url');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(url).select();
        try {
            document.execCommand("copy");
            new PNotify({
                // title: 'Success notice',
                text: "Copied to clipboard...",
                addclass: 'bg-success border-success text-white',
                delay: 3000
            });
        } catch (err) {
            new PNotify({
                title: 'Something went wrong',
                text: `Please try again`,
                addclass: 'bg-danger border-danger text-white',
                delay: 3000
            });
        }
        $temp.remove();
    }
</script>
