<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    $fullname = htmlspecialchars($_SESSION['fullname']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
    <script src="http://localhost/Projects/EDP_BASIC_SYSTEM/js/fetch_users.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header.top-nav {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .top-nav .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .top-nav .user-info i {
            font-size: 1.5rem;
        }

        .top-nav .logout-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: underline;
        }

        .top-nav .logout-btn:hover {
            color: #e8f5e8;
        }

        .container {
            display: flex;
            flex: 1;
        }

        aside.sidebar {
            width: 300px; /* Fixed width like before */
            background-color: #fff;
            padding: 1rem;
            box-shadow: 2px 0 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }

        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #ddd;
        }

        .sidebar .menu-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .sidebar .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sidebar .menu-item:hover {
            background-color: #e8f5e8;
        }

        .sidebar .menu-item i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        main.content {
            flex: 1;
            padding: 2rem;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
        }

        .stats-cards {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            width: 30%;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex: 1;
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card .icon {
            font-size: 3rem;
            color: #4CAF50;
            margin-bottom: 0.5rem;
        }

        .card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }

        .card .label {
            font-size: 1rem;
            color: #666;
        }

        .search-section {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .search-section input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .search-section button {
            padding: 0.75rem 1.5rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-section button:hover {
            background-color: #45a049;
        }

        .table-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex: 1;
        }

        .analysis-section {
            display: none;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
            flex: 1;
        }

        .chart-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .chart-container h3 {
            text-align: center;
            margin-bottom: 1rem;
            color: #333;
        }

        .chart-container canvas {
            max-width: 100%;
            height: auto;
        }
    </style>

    <header class="top-nav">
        <div class="user-info">
            <i class="fa-solid fa-circle-user"></i>
            <span><?php echo $fullname; ?></span>
        </div>
        <button class="logout-btn" onclick="location.href='http://localhost/Projects/EDP_BASIC_SYSTEM/php/index.php'">Log Out</button>
    </header>

    <div class="container">
        <aside class="sidebar">
            <div class="logo"> <!--Logo here--></div>
            <div class="menu-items">
                <div class="menu-item" id="dashboard-menu">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Dashboard</span>
                </div>
                <div class="menu-item" id="analysis-menu">
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>Analysis</span>
                </div>
            </div>
        </aside>

        <main class="content">
            <div class="stats-cards" id="stats-cards">
                <div class="card" id="total-user">
                    <div class="icon"><i class="fa-solid fa-chart-column"></i></div>
                    <div class="number">0</div>
                    <div class="label">Total registered users</div>
                </div>
            </div>

            <div class="search-section" id="search-section">
                <input type="search" name="search" id="search" placeholder="Search users...">
                <button>Search</button>
            </div>

            <div class="table-container" id="table-container">
                <table id="usersTable" class="display">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>City</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="analysis-section" id="analysis-section">
                <div class="chart-container">
                    <h3>Total Registrations per Day</h3>
                    <canvas id="dailyRegistrationChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Users by Gender</h3>
                    <canvas id="genderChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Users by City</h3>
                    <canvas id="cityChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            loadUsersTable();
            renderDailyRegistrationChart();
            // Update total users count after table is loaded
            $('#usersTable').on('draw.dt', function() {
                const count = $('#usersTable').DataTable().rows().count();
                $('#total-user .number').text(count);
            });
        });

        const dashboardMenu = document.getElementById('dashboard-menu');
        const analysisMenu = document.getElementById('analysis-menu');
        const statsCards = document.getElementById('stats-cards');
        const searchSection = document.getElementById('search-section');
        const tableContainer = document.getElementById('table-container');
        const analysisSection = document.getElementById('analysis-section');

        analysisMenu.addEventListener('click', () => {
            analysisSection.style.display = 'grid';
            statsCards.style.display = 'none';
            searchSection.style.display = 'none';
            tableContainer.style.display = 'none';
        });

        dashboardMenu.addEventListener('click', () => {
            analysisSection.style.display = 'none';
            statsCards.style.display = 'flex';
            searchSection.style.display = 'flex';
            tableContainer.style.display = 'block';
        });
    </script>
</body>
</html>
