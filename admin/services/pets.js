var PetService = {
    reload_pets_datatable: function () {
        Utils.get_datatable(
            "pets-datatable",
            Constants.get_api_base_url()+ "pets/pets",
            [
                { data: "name" },
                { data: "user_id" },
                { data: "species" },
                { data: "breed" },
                { data: "age" },
                { data: "disease" },
                { data: "action" },
            ]
        );
    },
    open_edit_pet_modal: function (pet_id) {
        RestClient.get("pets/pet?pet_id=" + pet_id, function (data) {
            $("#add-pet-modal").modal("toggle");
            $("#add-pet-form input[name='id']").val(data.id);
            $("#add-pet-form input[name='user_id']").val(data.user_id);
            $("#add-pet-form input[name='name']").val(data.name);
            $("#add-pet-form input[name='species']").val(data.species);
            $("#add-pet-form input[name='breed']").val(data.breed);
            $("#add-pet-form input[name='age']").val(data.age);
            $("#add-pet-form input[name='disease']").val(data.disease);
        });
    },
    delete_pet: function (pet_id) {
        if (
            confirm("Do you want to delete pet with the id " + pet_id + "?") ==
            true
        ) {
            RestClient.delete(
                "pets/delete/" + pet_id,
                {},
                function (data) {
                    PetService.reload_pets_datatable();
                }
            );
        }
    },
};
