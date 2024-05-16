var VetService = {
    reload_vets_datatable: function () {
        Utils.get_datatable(
            "vets-datatable",
            Constants.API_BASE_URL + "vets/vets", //get_vets.php
            [
                { data: "name" },
                { data: "surname" },
                { data: "email" },
                { data: "address" },
                { data: "username" },
                { data: "password" },
                { data: "approved" },
                { data: "station_id" },
                { data: "action" },
            ]
        );
    },
    open_edit_vet_modal: function (vet_id) {
        RestClient.get("vets/vet?vet_id=" + vet_id, function (data) {
            $("#add-vet-modal").modal("toggle");
            $("#add-vet-form input[name='id']").val(data.id);
            $("#add-vet-form input[name='name']").val(data.name);
            $("#add-vet-form input[name='surname']").val(data.surname);
            $("#add-vet-form input[name='email']").val(data.email);
            $("#add-vet-form input[name='address']").val(data.address);
            $("#add-vet-form input[name='username']").val(data.username);
            $("#add-vet-form input[name='password']").val(data.password);
            $("#add-vet-form input[name='approved']").val(data.approved);
            $("#add-vet-form input[name='station_id']").val(data.station_id);
        });
    },
    delete_vet: function (vet_id) {
        if (
            confirm("Do you want to delete vet with the id " + vet_id + "?") ==
            true
        ) {
            RestClient.delete(
                "vets/delete/" + vet_id, //delete_vet.php?id
                {},
                function (data) {
                    VetService.reload_vets_datatable();
                }
            );
        }
    },
};
