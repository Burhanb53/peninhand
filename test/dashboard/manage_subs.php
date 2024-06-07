<?php
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
}
error_reporting(0);
include ('includes/config.php');
if (!(isset($_SESSION['role']) && $_SESSION['role'] == 3)) {
    // User doesn't have the required role, redirect to index.php
    header("Location: ../index.php");
    exit(); // Make sure to exit after the redirect to prevent further execution
}
?>
<?php
session_start();
error_reporting(0);
include ('includes/config.php');

$sql = "SELECT * FROM teacher";
$result = $dbh->query($sql);
$teachers = $result->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin: 20px;
        }

        .card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            font-size: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header.inactive {
            background-color: #6c757d;
        }

        .card-body {
            padding: 15px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #f8f9fa;
        }

        .dropdown-divider {
            height: 1px;
            margin: 0.5rem 0;
            overflow: hidden;
            background-color: #dee2e6;
        }

        .extra-card {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            cursor: pointer;
            background-color: #28a745;
            color: white;
        }

        .extra-card .card-header {
            background-color: transparent;
        }

        .plus-icon {
            font-size: 2rem;
        }
    </style>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <?php include ('includes/navbar.php'); ?>

        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <?php include ('includes/sidebar.php'); ?>
        <!-- END MENU SIDEBAR-->


        <div class="container">
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "peninhand";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from database
    $sql = "SELECT * FROM subscription_plan";
    $result = $conn->query($sql);

    // Display subscription plans as cards
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $headerClass = $row["active"] == 0 ? "card-header inactive" : "card-header";
            echo '<div class="card">';
            echo '<div class="' . $headerClass . '">';
            echo '<h3 class="plan-name">' . $row["plan_name"] . '  ( Subscription ID : ' . $row["subscription_id"] . ')' . '</h3>';
            echo '<div class="dropdown">';
            echo '<div class="dropdown-toggle" onclick="toggleDropdown(this)" aria-haspopup="true" aria-expanded="false">';
            echo '<i class="fas fa-ellipsis-v"></i>';
            echo '</div>';
            echo '<div class="dropdown-menu">';
            if ($row["active"] == 0) {
                echo '<a class="dropdown-item activate" href="#" data-id="' . $row["id"] . '">Activate</a>';
            } else {
                echo '<a class="dropdown-item deactivate" href="#" data-id="' . $row["id"] . '">Deactivate</a>';
            }
            echo '<div class="dropdown-divider"></div>';
            echo '<a class="dropdown-item edit" href="#" onclick="showEditPopup(' . $row["id"] . ', \'' . $row["plan_name"] . '\', \'' . $row["description"] . '\', ' . $row["duration"] . ', ' . $row["price"] . ')">Edit</a>';
            echo '<a class="dropdown-item delete" href="#" onclick="confirmDelete(' . $row["id"] . ')">Delete</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<p class="description">' . $row["description"] . '</p>';
            echo '<p class="duration">Duration: ' . $row["duration"] . ' months</p>';
            echo '<p class="price">Price: ₹' . $row["price"] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
    <div class="card extra-card" onclick="showAddPopup()">
        <div class="card-header">
            <div class="plus-icon">&#43;</div>
        </div>
    </div>
</div>
<script>
    function toggleDropdown(element) {
        const dropdownMenu = element.nextElementSibling;
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }

    function showEditPopup(id, planName, description, duration, price) {
        // Your logic to show the edit popup
    }

    function confirmDelete(id) {
        // Your logic to confirm delete
    }

    function showAddPopup() {
        // Your logic to show the add popup
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.style.display = 'none';
            });
        }
    });
</script>

        <script>
            function toggleDropdown(element) {
                var dropdownMenu = element.nextElementSibling;
                dropdownMenu.classList.toggle('active');
            }
        </script>

    </div>
    <?php include ('includes/notes.php'); ?>

    <div id="addPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="hideAddPopup()">&times;</span>
            <h2>Add Plan</h2>
            <form id="addPlanForm" method="post">
                <label for="planName">Plan Name:</label>
                <input type="text" id="planName" name="planName" required><br><br>
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="5" required></textarea><br><br>
                <label for="duration">Duration:</label>
                <input type="number" id="duration" name="duration" required><br><br>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required><br><br>
                <input type="submit" value="Add Plan">
            </form>
        </div>
    </div>

    <div id="editPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="hideEditPopup()">&times;</span>
            <h2>Edit Plan</h2>
            <form id="editPlanForm" method="post">
                <input type="hidden" id="editPlanId" name="planId">
                <label for="editPlanName">Plan Name:</label>
                <input type="text" id="editPlanName" name="planName" required><br><br>
                <label for="editDescription">Description:</label>
                <textarea id="editDescription" name="description" rows="5" required></textarea><br><br>
                <label for="editDuration">Duration:</label>
                <input type="number" id="editDuration" name="duration" required><br><br>
                <label for="editPrice">Price:</label>
                <input type="number" id="editPrice" name="price" required><br><br>
                <input type="submit" value="Save Changes">
            </form>
        </div>
    </div>


    <script>
        function showAddPopup() {
            var addPopup = document.getElementById("addPopup");
            addPopup.style.display = "block";
        }

        function hideAddPopup() {
            var addPopup = document.getElementById("addPopup");
            addPopup.style.display = "none";
        }

        // JavaScript code to handle form submission
        document.getElementById("addPlanForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Retrieve form data
            var formData = new FormData(this);

            // Make a POST request to the backend
            fetch("backend/add_plan.php", { // Use the correct backend URL here
                method: "POST",
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json(); // Assuming the backend returns JSON data
                })
                .then(data => {
                    // Handle success response from the server
                    console.log(data); // Log the response data
                    // Optionally, perform actions based on the response
                    // For example, display a success message to the user
                    alert("Plan added successfully!");
                    // After successful submission, you may want to hide the popup or perform other actions
                    hideAddPopup();
                    // Reload the page to display the updated list of plans
                    location.reload();

                })
                .catch(error => {
                    // Handle error response from the server
                    console.error("There was a problem with the fetch operation:", error);
                    // Optionally, display an error message to the user
                    alert("Failed to add plan. Please try again later.");
                });
        });
    </script>
    <script>
        // Function to handle activation of a plan
        function activatePlan(planId) {
            // Make an AJAX request to activate the plan
            fetch("backend/update_plan_status.php", {
                method: "POST",
                body: new URLSearchParams({
                    action: "activate",
                    planId: planId
                })
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response
                    console.log(data);
                    // For example, display a success message to the user
                    alert(data.message);
                    // Optionally, reload the page or update UI based on the response
                    location.reload();
                })
                .catch(error => {
                    console.error("Error:", error);
                    // Display an error message to the user
                    alert("Failed to activate plan. Please try again later.");
                });
        }

        // Function to handle deactivation of a plan
        function deactivatePlan(planId) {
            // Make an AJAX request to deactivate the plan
            fetch("backend/update_plan_status.php", {
                method: "POST",
                body: new URLSearchParams({
                    action: "deactivate",
                    planId: planId
                })
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response
                    console.log(data);
                    // For example, display a success message to the user
                    alert(data.message);
                    // Optionally, reload the page or update UI based on the response
                    location.reload();
                })
                .catch(error => {
                    console.error("Error:", error);
                    // Display an error message to the user
                    alert("Failed to deactivate plan. Please try again later.");
                });
        }

        // Example: Activate plan
        document.querySelectorAll(".activate").forEach(item => {
            item.addEventListener("click", function () {
                const planId = this.dataset.id;
                activatePlan(planId);
            });
        });

        // Example: Deactivate plan
        document.querySelectorAll(".deactivate").forEach(item => {
            item.addEventListener("click", function () {
                const planId = this.dataset.id;
                deactivatePlan(planId);
            });
        });
    </script>
    <script>
        // Function to handle deletion of a plan
        function deletePlan(planId) {
            // Make an AJAX request to delete the plan
            fetch("backend/delete_plan.php", {
                method: "POST",
                body: new URLSearchParams({
                    planId: planId
                })
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response
                    console.log(data);
                    // Optionally, reload the page or update UI based on the response
                    location.reload();
                })
                .catch(error => {
                    console.error("Error:", error);
                    // Display an error message to the user
                    alert("Failed to delete plan. Please try again later.");
                });
        }

        // Function to confirm deletion of a plan
        function confirmDelete(planId) {
            var result = confirm("Are you sure you want to delete this plan?");
            if (result) {
                // If user confirms, call deletePlan function
                deletePlan(planId);
            }
        }

        // Example: Attach event listeners to delete links
        document.querySelectorAll(".delete").forEach(item => {
            item.addEventListener("click", function (event) {
                event.preventDefault(); // Prevent default link behavior
                const planId = this.dataset.id;
                // Call confirmDelete function with the plan ID
            });
        });
    </script>
    <script>
        // Function to display edit popup with pre-filled data
        function showEditPopup(planId, planName, description, duration, price) {
            document.getElementById("editPlanId").value = planId;
            document.getElementById("editPlanName").value = planName;
            document.getElementById("editDescription").value = description;
            document.getElementById("editDuration").value = duration;
            document.getElementById("editPrice").value = price;
            document.getElementById("editPopup").style.display = "block";
        }

        // Function to hide edit popup
        function hideEditPopup() {
            document.getElementById("editPopup").style.display = "none";
        }

        // Event listener for form submission
        document.getElementById("editPlanForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Gather form data
            var formData = new FormData(this);

            // Make an AJAX request to update the plan
            fetch("backend/update_plan.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response
                    console.log(data);
                    // Display a success message to the user
                    alert(data.message);
                    // Close the popup after successful submission
                    hideEditPopup();
                    // Reload the page or update UI as needed
                    location.reload();
                })
                .catch(error => {
                    console.error("Error:", error);
                    // Display an error message to the user
                    alert("Failed to update plan. Please try again later.");
                });
        });
    </script>
    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->