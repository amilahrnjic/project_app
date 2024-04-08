// Function to fetch veterinary station data from a JSON file
async function fetchStations() {
    try {
        const response = await fetch('datajson/stations.json'); // Path to your JSON file
        const data = await response.json();
        return data; // Assuming your JSON structure directly contains the array of stations
    } catch (error) {
        console.error('Error fetching stations:', error);
        return []; // Return an empty array in case of error
    }
}

// Function to display veterinary stations on the page
async function displayStations() {
    const stations = await fetchStations();
    const stationsContainer = document.querySelector('.row');

    // Check if stations container exists
    if (stationsContainer) {
        // Clear existing content
        stationsContainer.innerHTML = '';

        // Loop through each station and create HTML elements to display them
        stations.forEach(station => {
            const stationDiv = document.createElement('div');
            stationDiv.classList.add('col-md-6', 'col-12', 'station');

            // Construct HTML for the station
            const html = `
                <h2>${station.name}</h2>
                <p><strong>Address:</strong> ${station.address}</p>
                <p><strong>Email:</strong> <a href="mailto:${station.email}">${station.email}</a></p>
                <p><strong>Phone:</strong> ${station.phone}</p>
                <p><strong>Working Hours:</strong> ${station.working_hours}</p>
            `;

            // Set the HTML content of the station div
            stationDiv.innerHTML = html;

            // Append the station div to the stations container
            stationsContainer.appendChild(stationDiv);
        });
    }
}

// Call the displayStations function when the page is loaded
window.addEventListener('load', displayStations);
