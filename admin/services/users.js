var UserService = {
    reload_users_datatable: function () {
        Utils.get_datatable(
            "users-datatable",
            //  Constants.API_BASE_URL + "get_users.php",
            Constants.API_BASE_URL + "users/users",
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
        //which user i want to get
        RestClient.get("users/user?user_id=" + user_id, function (data) {
            //get_user.php?id=  probati bez ovog users/ +
            //ovdje moram postaviti rutu tipa ime neko /users/ a ne da bude prazno ovako samo id.
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
                //this trigger my backend code on delete.php
                "users/delete/" + user_id,
                {},
                function (data) {
                    UserService.reload_users_datatable();
                }
            );
        }
    },
};
