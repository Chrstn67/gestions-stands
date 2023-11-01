// // // Function to fetch data from an API and display it
// async function fetchDataAndDisplay(url, containerId) {
//     try {
//         const response = await fetch(url);
//         if (!response.ok) {
//             throw new Error(`HTTP error! Status: ${response.status}`);
//         }
//         const data = await response.json();

//         const container = document.getElementById(containerId);
//         container.innerHTML = JSON.stringify(data, null, 2);
//     } catch (error) {
//         console.error(`Error: ${error.message}`);
//     }
// }

// document.addEventListener('DOMContentLoaded', () => {
//     // Define the URLs for your APIs
//     const userApiUrl = 'http://localhost:8000/api/user';
//     const standApiUrl = 'http://localhost:8000/api/stand';
//     const reservationApiUrl = 'http://localhost:8000/api/reservation';

//     // Fetch and display user data
//     fetchDataAndDisplay(userApiUrl, 'user-list');

//     // Fetch and display stand data
//     fetchDataAndDisplay(standApiUrl, 'stand-list');

//     // Fetch and display reservation data
//     fetchDataAndDisplay(reservationApiUrl, 'reservation-list');
// });
