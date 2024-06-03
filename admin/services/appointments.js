var AppointmentService = {
    reload_appointments_datatable: function () {
        Utils.get_datatable(
            "appointments-datatable",
            Constants.API_BASE_URL + "appointments/appointments",
            [
                { data: "pet_id" },
                { data: "doctor_id" },
                { data: "date" },
                { data: "action" },
            ]
        );
    },
    open_edit_appointment_modal: function (appointment_id) {
        RestClient.get(
            "appointments/appointment?appointment_id=" + appointment_id,
            function (data) {
                $("#add-appointment-modal").modal("toggle");
                $("#add-appointment-form input[name='id']").val(data.id);
                $("#add-appointment-form input[name='pet_id']").val(
                    data.pet_id
                );
                $("#add-appointment-form input[name='doctor_id']").val(
                    data.doctor_id
                );
                $("#add-appointment-form input[name='date']").val(data.date);
            }
        );
    },
    delete_appointment: function (appointment_id) {
        if (
            confirm(
                "Do you want to delete appointment with the id " +
                    appointment_id +
                    "?"
            ) == true
        ) {
            RestClient.delete(
                "appointments/delete/" + appointment_id,
                {},
                function (data) {
                    AppointmentService.reload_appointments_datatable();
                }
            );
        }
    },
};
