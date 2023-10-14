<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add the Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Add your custom CSS for additional styling -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">Dashboard</a>
                    <a href="#" class="list-group-item list-group-item-action">Applicants</a>
                    <a href="#" class="list-group-item list-group-item-action">Settings</a>
                    <a href="#" class="list-group-item list-group-item-action">Logout</a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9">
                <h2 class="mb-4">Applicants List</h2>
                <table class="table table-dark table-striped-columns">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Connect to your database
                        $conn = new mysqli("localhost", "root", "", "hyperbusinessconsult");

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch applicant data from the database
                        $sql = "SELECT * FROM registration_data";
                        $result = $conn->query($sql);

                        // Loop through the results and display in the table
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['full_name']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>";
                                echo "<a href='view_applicant.php?id={$row['id']}' class='btn btn-primary'>View</a>";
                                echo "<a href='grant_application.php?id={$row['id']}' class='btn btn-success'>Grant</a>";
                                echo "<a href='deny_application.php?id={$row['id']}' class='btn btn-danger'>Deny</a>";
                
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No applicants found</td></tr>";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add the Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
