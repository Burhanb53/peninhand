<?php
session_start();
error_reporting(0);
include('includes/config.php');

$sql = "SELECT * FROM teacher";
$result = $dbh->query($sql);
$teachers = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Directory</title>
    <link rel="icon" href="img/logo.png" type="image/png">

    <link rel="stylesheet" href="css/bootstrap1.min.css">
    <link rel="stylesheet" href="vendors/themefy_icon/themify-icons.css">
    <link rel="stylesheet" href="vendors/swiper_slider/css/swiper.min.css">
    <link rel="stylesheet" href="vendors/select2/css/select2.min.css">
    <link rel="stylesheet" href="vendors/niceselect/css/nice-select.css">
    <link rel="stylesheet" href="vendors/owl_carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="vendors/gijgo/gijgo.min.css">
    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css">
    <link rel="stylesheet" href="vendors/tagsinput/tagsinput.css">
    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css">
    <link rel="stylesheet" href="vendors/morris/morris.css">
    <link rel="stylesheet" href="vendors/material_icon/material-icons.css">
    <link rel="stylesheet" href="css/metisMenu.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
        }

        .card {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin: 10px;
            width: calc(33.33% - 20px);
            overflow: hidden;
            position: relative;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            position: relative;
        }

        .plan-name {
            margin: 0;
        }

        .dropdown {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: #fff;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            top: 30px;
            right: 0;
            z-index: 1;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-item {
            padding: 10px;
            color: #333;
            text-decoration: none;
            display: block;
        }

        .dropdown-item:hover {
            background-color: #007bff !important;
            color: #fff !important;
        }

        .card-body {
            padding: 20px;
        }

        .description,
        .duration,
        .price {
            margin: 0 0 10px;
        }

        @media(max-width: 768px) {
            .card {
                width: calc(100% - 20px);
            }
        }

        /* Additional CSS for extra card */
        .extra-card {
            border: 2px dashed #007bff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #007bff;
            min-height: 200px;
        }

        .plus-icon {
            font-size: 48px;
        }

        /* Additional CSS for inactive header */
        .inactive {
            background-color: #ff0000;
            /* Red color for inactive header */
        }
    </style>
    <style>
        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .popup-content {
            background-color: #fefefe;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            width: 60%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
        }

        .popup h2 {
            margin-top: 0;
        }

        #addPlanForm label,
        #editPlanForm label {
            display: block;
            margin-bottom: 5px;
        }

        #addPlanForm input[type="text"],
        #editPlanForm input[type="text"],
        #addPlanForm textarea,
        #editPlanForm textarea,
        #addPlanForm input[type="number"],
        #editPlanForm input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #addPlanForm input[type="submit"],
        #editPlanForm input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #addPlanForm input[type="submit"]:hover,
        #editPlanForm input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body class="crm_body_bg">

    <?php include('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">

        <div class="main_content_iner p-1">
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
                        echo '<div class="card-body" style="font-size:20px;">';
                        echo '<p class="description" style="font-size:20px;">' . $row["description"] . '</p>';
                        echo '<p class="duration" style="font-size:20px;">Duration: ' . $row["duration"] . ' months</p>';
                        echo '<p class="price" style="font-size:20px;">Price: ₹' . $row["price"] . '</p>';
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
                    var dropdownMenu = element.nextElementSibling;
                    dropdownMenu.classList.toggle('active');
                }
            </script>

        </div>
        </div>
        </div>
        </div>


    </section>
    <?php include('includes/notes.php'); ?>

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
        document.getElementById("addPlanForm").addEventListener("submit", function(event) {
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
            item.addEventListener("click", function() {
                const planId = this.dataset.id;
                activatePlan(planId);
            });
        });

        // Example: Deactivate plan
        document.querySelectorAll(".deactivate").forEach(item => {
            item.addEventListener("click", function() {
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
            item.addEventListener("click", function(event) {
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
        document.getElementById("editPlanForm").addEventListener("submit", function(event) {
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


</body>


<script src="js/jquery1-3.4.1.min.js"></script>

<script src="js/popper1.min.js"></script>

<script src="js/bootstrap1.min.js"></script>

<script src="js/metisMenu.js"></script>

<script src="vendors/count_up/jquery.waypoints.min.js"></script>

<script src="vendors/chartlist/Chart.min.js"></script>

<script src="vendors/count_up/jquery.counterup.min.js"></script>

<script src="vendors/swiper_slider/js/swiper.min.js"></script>

<script src="vendors/niceselect/js/jquery.nice-select.min.js"></script>

<script src="vendors/owl_carousel/js/owl.carousel.min.js"></script>

<script src="vendors/gijgo/gijgo.min.js"></script>

<script src="vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatable/js/buttons.flash.min.js"></script>
<script src="vendors/datatable/js/jszip.min.js"></script>
<script src="vendors/datatable/js/pdfmake.min.js"></script>
<script src="vendors/datatable/js/vfs_fonts.js"></script>
<script src="vendors/datatable/js/buttons.html5.min.js"></script>
<script src="vendors/datatable/js/buttons.print.min.js"></script>
<script src="js/chart.min.js"></script>

<script src="vendors/progressbar/jquery.barfiller.js"></script>

<script src="vendors/tagsinput/tagsinput.js"></script>

<script src="vendors/text_editor/summernote-bs4.js"></script>
<script src="vendors/apex_chart/apexcharts.js"></script>
<script src="js/custom.js"></script>


</html>