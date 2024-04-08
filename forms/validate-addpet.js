$(document).ready(function() {
    $("#validate-addpet").validate({
        rules: {
            petname: {
                required: true,
                minlength: 2
            },
            species: {
                required: true,
                minlength: 3
            },
            breed: {
                required: true,
                minlength: 3
            },
            age: {
                required: true
            },
            disease: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            petname: {
                required: "Please enter pet name",
                minlength: "Name must be at least 2 characters"
            },
            species: {
                required: "Please enter species",
                minlength: "Species must be at least 3 characters"
            },
            breed: {
                required: "Please enter breed",
                minlength: "Breed must be at least 3 characters"
            },
            age: {
                required: "Please enter age"
            },
            disease: {
                required: "Please enter disease",
                minlength: "Disease must be at least 3 characters"
            }
        },
        submitHandler: function(form) {
            const petFormData = {
                petname: $('#petname').val(),
                species: $('#species').val(),
                breed: $('#breed').val(),
                age: $('#age').val(),
                disease: $('#disease').val()
            };
            savePetData(petFormData); // Save pet data to local storage
            form.reset(); // Reset form
            alert('Pet registration submitted successfully!');
            return false; // Prevent form submission
        }
    });

    // Function to retrieve data from local storage
    function retrievePetData() {
        const storedData = localStorage.getItem('petData');
        return storedData ? JSON.parse(storedData) : [];
    }

    // Function to save pet data to local storage with IDs
    function savePetData(data) {
        const storedData = retrievePetData();
        const newData = { id: Date.now(), ...data }; // Generate unique ID using timestamp
        storedData.push(newData);
        localStorage.setItem('petData', JSON.stringify(storedData));
    }
});
