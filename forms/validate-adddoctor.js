$(document).ready(function() {
    $("#form-doctor").validate({
        rules: {
            'Name': { // Use name attribute here
                required: true,
                minlength: 3
            },
            'Email': {
                required: true,
                email: true
            },
            'UserName': {
                required: true
            },
            'Address': {
                required: true
            },
            'Surname': {
                required: true,
                minlength: 3
            },
            'Phone': {
                required: true,
                number: true,
                minlength: 9
            },
            'Password': {
                required: true,
                minlength:8
            },
            'Profession': {
                required: true
            }
        },
        messages: {
            'Name': {
                required: "Please enter your name",
                minlength: "Name must be at least 3 characters"
            },
            'Email': {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            'UserName': {
                required: "Please enter your username"
            },
            'Address': {
                required: "Please enter your address"
            },
            'Surname': {
                required: "Please enter your surname",
                minlength: "Surname must be at least 3 characters"
            },
            'Phone': {
                required: "Please enter your phone number",
                number: "Please enter a valid phone number",
                minlength: "Phone number must be at least 9 characters"
            },
            'Password': {
                required: "Please enter your password",
                minlength: "Password must be at least 8 characters"
            },
            'Profession': {
                required: "Please enter profession"
            }
        },
        submitHandler: function(form) {
            const formData = {
                name: $('#doctor-name').val(),
                email: $('#doctor-email').val(),
                username: $('#doctor-username').val(),
                address: $('#doctor-address').val(),
                surname: $('#doctor-surname').val(),
                phone: $('#doctor-phone').val(),
                password: $('#doctor-password').val(),
                profession: $('#doctor-profession').val()
            };
            saveData(formData); // Save data to local storage
            form.reset(); // Reset form
            alert('Data submitted successfully!');
            return false; // Prevent form submission
        }
    });

    // Function to retrieve data from local storage
    function retrieveData() {
        const storedData = localStorage.getItem('doctorData');
        return storedData ? JSON.parse(storedData) : [];
    }

    // Function to save data to local storage
    function saveData(data) {
        const storedData = retrieveData();
        storedData.push(data);
        localStorage.setItem('doctorData', JSON.stringify(storedData));
    }
});
