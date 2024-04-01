$(document).ready(function() {
    $("#form-appointment").validate({
        rules: {
            appname: {
                required: true,
                minlength: 3
            },
            appsurname: {
                required: true,
                minlength: 3
            },
            appemail: {
                email: true
            },
            appphone: {
                required: true,
                number: true,
                minlength: 9
            },
            appvet_station: {
                required: true
            },
            appdate: {
                required: true,
                // You can remove the custom validation method as it's commented out
            }
        },
        messages: {
            appname: {
                required: "Please enter your name",
                minlength: "Name must be at least 3 characters"
            },
            appsurname: {
                required: "Please enter your surname",
                minlength: "Surname must be at least 3 characters"
            },
            appemail: "Please enter a valid email address",
            appphone: "Please enter a valid phone number",
            appvet_station: "Please enter a veterinary station",
            appdate: "Please select a valid date"
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
    const newData = { id: Date.now(), ...data };
    storedData.push(newData);
    localStorage.setItem('petData', JSON.stringify(storedData));
}

// Function to handle pet registration form submission
function handlePetRegistration(event) {
    event.preventDefault();
    if ($('#validate-addpet').valid()) {
        const petFormData = {
            petname: $('#petname').val(),
            petspecies: $('#species').val(),
            petbreed: $('#breed').val(),
            petage: $('#age').val(),
            petdisease: $('#disease').val()
        };
        savePetData(petFormData); // Save pet data to local storage
        document.getElementById('validate-addpet').reset(); // Reset form
        alert('Pet registration submitted successfully!');
    }
}

// Event listener for pet registration form submission
$(document).ready(function() {
    document.getElementById('validate-addpet').addEventListener('submit', handlePetRegistration);


});

});
