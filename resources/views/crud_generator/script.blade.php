

<script>
    $(document).ready(function () {


        $(document).on("click", "#add_fields", function () {
            {{--var id = $(this).data('id');--}}
            {{--$.ajax({--}}
            {{--    url: "{{route('crud-generator.show_fields')}}",--}}
            {{--    type: "GET",--}}
            {{--    dataType: "json",--}}
            {{--    success: function (data) {--}}

            {{--        $(".content_field").html(data.html)--}}
            {{--        $("#modal_form_vertical").modal("show");--}}
            {{--    }--}}
            {{--});--}}

            var html = `<tr>
                            <td><select name="filed_type[]" class="form-control" >
                                    <option value="string">Text</option>
                                    <option value="text">TEXT AREA</option>
                                    <option value="char">Char</option>
                                    <option value="date">Date</option>
                                    <option value="datetime">Date Time</option>
                                    <option value="time"> Time</option>
                                    <option value="timestamp"> Timestamp</option>
                                    <option value="longtext"> LongText</option>
                                    <option value="integer"> Integer</option>
                                    <option value="float"> Float</option>
                                    <option value="image"> Image</option>
                                    <option value="ckeditor"> Ckeditor</option>
                                </select></td>
                            <td> <input type="text" class="form-control" name="database_name[]" required
                                       placeholder="CModel Name"></td>

                            <td><input type="checkbox" name="is_required[]" checked ></td>
                            <td><input type="checkbox" name="is_show[]" checked ></td>
                        </tr>`;
            $('.tbody').append(html)
        })

        $(document).on("click", ".submit_form_field", function () {


            var filed_type = $("#filed_type").val();
            var database_name = $("#database_name").val();
            var is_required = $("#is_required").val();


            var is_check = '';
            if(is_required == 'on')
            {
                is_check = 'checked';
            }

            var html = `<tr>
                            <td><select name="filed_type[]" class="form-control" id="filed_type">
                                    <option value="string">Text</option>
                                    <option value="text">TEXT AREA</option>
                                </select></td>
                            <td> <input type="text" class="form-control" id="database_name" name="database_name[]" required
                                       placeholder="CModel Name"></td>

                            <td><input type="checkbox" name="is_required[]" checked id="is_required"></td>
                        </tr>`;
            $('.tbody').append(html)

        })
    })

</script>
