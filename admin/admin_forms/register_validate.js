$(document).ready(function() {
    $("#register_validate").validate({
        // Validation rules and messages
        rules: {
            'firstname': {
                required: true,
                minlength: 3
            },
            'lastname': {
                required: true,
                minlength: 3
            },
            'email': {
                required: true,
                email: true
            },
            'password': {
                required: true,
                minlength: 8
            }
        },
        messages: {
            'firstname': {
                required: "Please enter your first name",
                minlength: "First name must be at least 3 characters"
            },
            'lastname': {
                required: "Please enter your last name",
                minlength: "Last name must be at least 3 characters"
            },
            'email': {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            'password': {
                required: "Please enter your password",
                minlength: "Password must be at least 8 characters"
            }
        },
        submitHandler: function(form) {
            // Handle form submission
            const formData = {
                firstname: $('#firstname').val(),
                lastname: $('#lastname').val(),
                email: $('#email').val(),
                password: $('#password').val()
            };
            saveData(formData); // Save data to local storage
            form.reset(); // Reset form
            alert('Account created successfully!');
            window.location.href = "login.html";
            return false; // Prevent form submission
        }
    });

    // Function to retrieve data from local storage
    function retrieveData() {
        const storedData = localStorage.getItem('userRegister');
        return storedData ? JSON.parse(storedData) : [];
    }

    // Function to save data to local storage
    function saveData(data) {
        const storedData = retrieveData();
        storedData.push(data);
        localStorage.setItem('userRegister', JSON.stringify(storedData));
    }
});
