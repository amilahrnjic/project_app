$("#form_vetstation").valid({

    rules: {
        name: {
            required:true,
            minlength: 3
        },
        email: {
            email:true
        },

        address: {
            minlength:5
        },
        phone: {
            number:true,
            minlength:9

        }


    },

    messages: {
        name : {
        required: "Please eneter your name",
        minlength: "Name at least 3 characters"
        },


        address : {
            minlength: "Address must be at least 5 characters"
        },
        email: "Please eneter your email",
        phone: "Please eneter your phone",


    },


/*
    submitHandler: function(form) {  //used for form submition 
      form.submit();
    }
   }); */

  
});


// Function to retrieve data from local storage
function retrieveData() {
    const storedData = localStorage.getItem('vetStations');
    return storedData ? JSON.parse(storedData) : [];
}

// Function to save data to local storage with IDs
function saveData(data) {
    const storedData = retrieveData();
    const newData = { id: Date.now(), ...data }; // Generate unique ID using timestamp
    storedData.push(newData);
    localStorage.setItem('vetStations', JSON.stringify(storedData));
}

// Function to handle form submission
function handleSubmit(event) {
    event.preventDefault();
    if ($('#form_vetstation').valid()) {
        const formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            address: $('#address').val(),
            phone: $('#phone').val(),
            working_hours: $('#working_hours').val()
        };
        saveData(formData); // Save data to local storage
        document.getElementById('form_vetstation').reset(); // Reset form
        alert('Data submitted successfully!');
    }
}

// Event listener for form submission
document.getElementById('form_vetstation').addEventListener('submit', handleSubmit);



    