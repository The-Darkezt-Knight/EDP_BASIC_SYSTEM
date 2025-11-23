let genderChartInstance = null;
let cityChartInstance = null;
let dailyChartInstance = null;

//This fetches the users and displays them in the table
function loadUsersTable() {
    $('#usersTable').DataTable({

        searching: false,
        lengthChange: false,
        paging: true,

        destroy: true,
        ajax: {
            url: "get_users.php",
            dataSrc: ""
        },
        columns: [
            { data: "fullname" },
            { data: "email" },
            { data: "gender" },
            { data: "city" },
            { data: "password" }
        ]
    });
}

//Search functionality
let table;

function loadUsersTable(searchTerm = '') {
    if ($.fn.DataTable.isDataTable('#usersTable')) {
        table.clear().destroy();
    }

    table = $('#usersTable').DataTable({
        searching: false,
        lengthChange: false,
        ajax: {
            url: 'get_users.php',
            type: 'GET',
            data: { search: searchTerm },
            dataSrc: ''
        },
        columns: [
            { data: "fullname" },
            { data: "email" },
            { data: "gender" },
            { data: "city" },
            { data: "password" }
        ]
    });
}

$(document).ready(function() {
    loadUsersTable();

    $('#search').on('keyup', function() {
        const term = $(this).val();
        loadUsersTable(term);
    });
});



//Fetch and update total users card
function updateTotalUsersCard() {
    fetch('get_total_users.php')
        .then(response => response.json())
        .then(data => {
            document.querySelector('#total-user .body p').textContent = data.total;
        })
        .catch(err => console.error('Error fetching total users:', err));
}

document.addEventListener('DOMContentLoaded', () => {
    updateTotalUsersCard();
    setInterval(updateTotalUsersCard, 10000);
});

//fetch users for analysis chart
function renderGenderChart() {
    fetch('get_users_gender.php')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(d => d.gender);
            const counts = data.map(d => d.count);
            const ctx = document.getElementById('genderChart').getContext('2d');

            // Destroy previous chart if exists
            if (genderChartInstance) genderChartInstance.destroy();

            genderChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Users by Gender',
                        data: counts,
                        backgroundColor: ['#36A2EB', '#FF6384']
                    }]
                },
                options: { responsive: true }
            });
        });
}

function renderCityChart() {
    fetch('get_users_city.php')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(d => d.city);
            const counts = data.map(d => d.count);
            const ctx = document.getElementById('cityChart').getContext('2d');

            if (cityChartInstance) cityChartInstance.destroy();

            cityChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Users by City',
                        data: counts,
                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        });
}

function renderDailyRegistrationChart() {
    fetch('get_daily_registration.php')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(d => d.reg_date);
            const counts = data.map(d => d.count);
            const ctx = document.getElementById('dailyRegistrationChart').getContext('2d');

            if (dailyChartInstance) dailyChartInstance.destroy();

            dailyChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Daily Registrations',
                        data: counts,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { responsive: true }
            });
        });
}

document.addEventListener('DOMContentLoaded', () => {
    renderGenderChart();
    renderCityChart();
    renderDailyRegistrationChart();
});



