$(document).ready(function() {
    $("#form_uservalidate").validate({
        rules: {
            Username: {
                required: true,
                minlength: 3
            },
            Password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            Username: {
                required: "Please enter your username",
                minlength: "Username must be at least 3 characters"
            },
            Password: {
                required: "Please enter your password",
                minlength: "Password must be at least 8 characters"
            }
        },
        submitHandler: function(form) {
            const formData = {
                Username: $('#Username').val(),
                Password: $('#Password').val()
            };
            saveData(formData); // Save user data to local storage
            form.reset(); // Reset form
            alert('Login data submitted successfully!');
            window.location.href = "index.html";

            return false; // Prevent form submission
        }
    });

    // Function to retrieve data from local storage
    function retrieveData() {
        const storedData = localStorage.getItem('userData');
        return storedData ? JSON.parse(storedData) : [];
    }

    // Function to save data to local storage with IDs
    function saveData(data) {
        const storedData = retrieveData();
        const newData = { id: Date.now(), ...data }; // Generate unique ID using timestamp
        storedData.push(newData);
        localStorage.setItem('userData', JSON.stringify(storedData));
    }
});
