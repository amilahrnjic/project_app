var StationService = {
    reload_stations_datatable: function () {
        Utils.get_datatable(
            "stations-datatable",
            Constants.get_api_base_url() + "stations/stations",
            [
                { data: "name" },
                { data: "address" },
                { data: "phone" },
                { data: "description" },
                { data: "action" },
            ]
        );
    },
    open_edit_station_modal: function (station_id) {
        RestClient.get("stations/station?station_id=" + station_id, function (data) {
            $("#add-station-modal").modal("toggle");
            $("#add-station-form input[name='id']").val(data.id);
            $("#add-station-form input[name='name']").val(data.name);
            $("#add-station-form input[name='address']").val(data.address);
            $("#add-station-form input[name='phone']").val(data.phone);
            $("#add-station-form textarea[name='description']").val(
                data.description
            );
        });
    },
    delete_station: function (station_id) {
        if (
            confirm(
                "Do you want to delete station with the id " + station_id + "?"
            ) == true
        ) {
            RestClient.delete(
                "stations/delete/" + station_id,
                {},
                function (data) {
                    StationService.reload_stations_datatable();
                }
            );
        }
    },
};
