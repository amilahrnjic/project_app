var UserService = {
    reload_users_datatable: function () {
        Utils.get_datatable(
            "users-datatable",
            Constants.API_BASE_URL + "get_users.php",
            [
                { data: "name" },
                { data: "surname" },
                { data: "email" },
                { data: "phone" },
                { data: "username" },
                { data: "password" },
                { data: "action" },
            ]
        );
    },
    open_edit_user_modal: function (user_id) {
        RestClient.get("get_user.php?id=" + user_id, function (data) {
            $("#add-user-modal").modal("toggle");
            $("#add-user-form input[name='id']").val(data.id);
            $("#add-user-form input[name='name']").val(data.name);
            $("#add-user-form input[name='surname']").val(data.surname);
            $("#add-user-form input[name='email']").val(data.email);
            $("#add-user-form input[name='phone']").val(data.phone);
            $("#add-user-form input[name='username']").val(data.username);
            $("#add-user-form input[name='password']").val(data.password);
        });
    },
    delete_user: function (user_id) {
        if (
            confirm(
                "Do you want to delete user with the id " + user_id + "?"
            ) == true
        ) {
            RestClient.delete(
                "delete_user.php?id=" + user_id,
                {},
                function (data) {
                    UserService.reload_users_datatable();
                }
            );
        }
    },
};
