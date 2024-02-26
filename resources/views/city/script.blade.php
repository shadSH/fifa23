

<script>
    $(document).ready(function () {
        const cityColumns = [
            { data: "id", name: "id" },
            { data: "name", name: "name" },
            { data: "checkbox", name: "checkbox" },
            { data: "created_by", name: "created_by" },
            { data: "created_at", name: "created_at" },
            { data: "action", name: "action", "class": "text-center" }
        ];
        initializeDataTable("#info_table", "{{route('city.index')}}", cityColumns);
        editHandler("{{url('/city')}}")

    })

</script>
