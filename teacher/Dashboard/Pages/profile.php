<?php
session_start();
include('../../../includes/config.php');

// Fetch doubts for the current user
$teacher_id = $_SESSION['user_id'];
$video_call_count = 0;
$doubt_count = 0;
$answer_count = 0;

// Fetch all doubt_ids from the doubt table for the user
$stmt_doubt_ids = $dbh->prepare("SELECT doubt_id FROM doubt WHERE teacher_id = :teacher_id");
$stmt_doubt_ids->bindParam(':teacher_id', $teacher_id);
$stmt_doubt_ids->execute();
$doubt_ids = $stmt_doubt_ids->fetchAll(PDO::FETCH_COLUMN);

// Initialize video call count
$video_call_count = 0;

// Loop through each doubt_id and count rows from video_call table
foreach ($doubt_ids as $doubt_id) {
  $stmt_video_call_count = $dbh->prepare("SELECT COUNT(*) AS video_call_count FROM video_call WHERE doubt_id = :doubt_id");
  $stmt_video_call_count->bindParam(':doubt_id', $doubt_id);
  $stmt_video_call_count->execute();
  $video_call_row = $stmt_video_call_count->fetch(PDO::FETCH_ASSOC);
  $video_call_count += $video_call_row['video_call_count'];
}

// Count rows from doubt table
$stmt_doubt = $dbh->prepare("SELECT COUNT(*) AS doubt_count FROM doubt WHERE teacher_id = :teacher_id");
$stmt_doubt->bindParam(':teacher_id', $teacher_id);
$stmt_doubt->execute();
$doubt_row = $stmt_doubt->fetch(PDO::FETCH_ASSOC);
$doubt_count = $doubt_row['doubt_count'];

// Count rows from doubt table where feedback = 1
$stmt_answer = $dbh->prepare("SELECT COUNT(*) AS answer_count FROM doubt WHERE teacher_id = :teacher_id AND feedback = 1");
$stmt_answer->bindParam(':teacher_id', $teacher_id);
$stmt_answer->execute();
$answer_row = $stmt_answer->fetch(PDO::FETCH_ASSOC);
$answer_count = $answer_row['answer_count'];


$stmt = $dbh->prepare("SELECT * FROM teacher WHERE teacher_id = :teacher_id ORDER BY created_at DESC LIMIT 1");
$stmt->bindParam(':teacher_id', $teacher_id);
$stmt->execute();
// Fetch all rows from the result set as an array
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Store all values in a variable
$userData = array();

foreach ($user as $userInfo) {
  $id = $userInfo['id'];
  $photo = $userInfo['photo'];
  $name = $userInfo['name'];
  $email = $userInfo['email'];
  $contact = $userInfo['contact'];
  $age = $userInfo['age'];
  $gender = $userInfo['gender'];
  $tech_stack = $userInfo['tech_stack'];
  $experience = $userInfo['experience'];
  $resume = $userInfo['resume'];
  $address = $userInfo['address'];
  $city = $userInfo['city'];
  $state = $userInfo['state'];
  $pin = $userInfo['pin'];
  $active = $userInfo['active'];


  // Now you can use these variables as needed
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="CodeHim">
  <title>Profile Page</title>

  <!-- Style CSS -->
  <link rel="stylesheet" href="./css/style.css">
  <!-- Demo CSS (No need to include it into your project) -->
  <link rel="stylesheet" href="./css/demo.css">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">
  <link rel="icon" href="../img/logo.png" type="image/png">

  <link rel="stylesheet" href="../css/bootstrap1.min.css">

  <link rel="stylesheet" href="../vendors/themefy_icon/themify-icons.css">

  <link rel="stylesheet" href="../vendors/swiper_slider/css/swiper.min.css">

  <link rel="stylesheet" href="../vendors/select2/css/select2.min.css">

  <link rel="stylesheet" href="../vendors/niceselect/css/nice-select.css">

  <link rel="stylesheet" href="../vendors/owl_carousel/css/owl.carousel.css">

  <link rel="stylesheet" href="../vendors/gijgo/gijgo.min.css">

  <link rel="stylesheet" href="../vendors/font_awesome/css/all.min.css">
  <link rel="stylesheet" href="../vendors/tagsinput/tagsinput.css">

  <link rel="stylesheet" href="../vendors/datepicker/date-picker.css">

  <link rel="stylesheet" href="../vendors/datatable/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../vendors/datatable/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="../vendors/datatable/css/buttons.dataTables.min.css">

  <link rel="stylesheet" href="../vendors/text_editor/summernote-bs4.css">

  <link rel="stylesheet" href="../vendors/morris/morris.css">

  <link rel="stylesheet" href="../vendors/material_icon/material-icons.css">

  <link rel="stylesheet" href="../css/metisMenu.css">

  <link rel="stylesheet" href="../css/style1.css">
  <link rel="stylesheet" href="../css/colors/default.css" id="colorSkinCSS">
  <!-- Add these links in the head section of your HTML -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
    .additional-details {

      margin-left: auto 10px;

    }

    .additional-details li {
      list-style: none;
      border: 2px solid #ddd;
      padding: 10px;
      margin: 10px;
      border-radius: 50rem;
      background: #fff;
      color: #333;
      transition: background 0.3s ease;
      width: calc(100% - 32px);
      font-size: 20px;
    }

    .additional-details li:hover {
      background: #f0f0f0;
    }

    .details {
      display: none;
      max-width: 800px;
      background-color: #fff;
      border-radius: 2rem;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
      align-items: flex-start;
      justify-content: center;
      margin: auto;
      padding: 20px;
      transition: box-shadow 0.3s ease;
      margin: 10px auto;
      margin-bottom: 20px;
    }

    .details:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 1);
    }

    .edit-details-button {
      background-color: #3498db;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
      margin-top: 20px;
    }

    .edit-details-button:hover {
      background: #2980b9;
      /* Darker blue background on hover */
    }

    @media (max-width: 990px) {
      .details {
        max-width: 420px;
      }
    }

    .profile-page .content__avatar {
      background: #8f6ed5 url("../uploads/profile/<?php echo $photo ?>") center/cover;
    }
  </style>
  <style>
.toggle-container {
  display: inline-block;
  overflow: hidden;
}

.toggle-button {
  display: inline-block;
  width: 80px;
  height: 40px;
  background-color: #ff6666; /* Default background color for off state */
  border-radius: 20px;
  position: relative;
  cursor: pointer;
  transition: background-color 0.3s;
  

}

/* Change background color to green for 'on' state */
.toggle-button.toggle-on {
  background-color: #66cc66;
}

.toggle-button::before {
  content: "";
  position: absolute;
  width: 40px;
  height: 40px;
  background-color: white !important;
  border-radius: 50%;
  transition: background-color 0.3s;

}

/* Move the toggle handle to the right for 'on' state */
.toggle-button.toggle-on::before {
  left: 40px;
}

/* Move the toggle handle to the left for 'off' state */
.toggle-button.toggle-off::before {
  left: 0;
}

/* Change the background color of the left part for 'on' state */
.toggle-button.toggle-on::before {
  background-color: #66cc66;
}

/* Change the background color of the right part for 'off' state */
.toggle-button.toggle-off::before {
  background-color: #ff6666;
}
@media (max-width: 767px) {
  .toggle-button {
    width: 50px; /* Adjusted width for mobile */
    height: 25px; /* Adjusted height for mobile */
    border-radius: 12.5px; /* Adjusted border radius for mobile */
  }

  .toggle-button::before {
    width: 25px; /* Adjusted width of toggle handle for mobile */
    height: 25px; /* Adjusted height of toggle handle for mobile */
  }
  .toggle-button.toggle-on::before {
  left: 25px;
}
}
</style>
</head>

<body>
  <?php include('../includes/sidebar.php'); ?>
  <section class="main_content dashboard_part">
    <?php include('../includes/navbar.php'); ?>
    <!--$%adsense%$-->
    <main class="cd__main" style="background-color: #F5F7F9;">
      <!-- Start DEMO HTML (Use the following code into your project)-->
      <div class="profile-page">
        <div class="content">
          <div class="content__cover">
            <div class="content__avatar"><a href="../img/profile.jpg"></a></div>
            <div class="content__bull"><span></span><span></span><span></span><span></span><span></span>
            </div>
          </div>

          <div class="content__actions"><a href="video_call.php">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <path fill="currentColor" d="M192 256A112 112 0 1 0 80 144a111.94 111.94 0 0 0 112 112zm76.8 32h-8.3a157.53 157.53 0 0 1-68.5 16c-24.6 0-47.6-6-68.5-16h-8.3A115.23 115.23 0 0 0 0 403.2V432a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48v-28.8A115.23 115.23 0 0 0 268.8 288z">
                </path>
                <path fill="currentColor" d="M480 256a96 96 0 1 0-96-96 96 96 0 0 0 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592a48 48 0 0 0 48-48 111.94 111.94 0 0 0-112-112z">
                </path>
              </svg><span>Video Call</span></a>
              <div class="toggle-container">
  <div class="toggle-button toggle-off"></div>
</div>
          </div>
          <div class="content__title">
            <h1><?php echo $name ?></h1><span><?php echo $address . ", " . $city . ", " . $state . " (" . $pin . ")"  ?></span>
          </div>
          <ul class="content__list">
            <li><span><?php echo $doubt_count ?></span>Doubts</li>
            <li><span><?php echo $answer_count ?></span>Answers</li>
            <li><span><?php echo $video_call_count ?></span>Video Calls</li>
          </ul>
          <div class="content__button">
            <a id="toggleButton" class="button" href="javascript:void(0);" onclick="toggleDetails()">
              <div class="button__border"></div>
              <div class="button__bg"></div>
              <p class="button__text" style="color: white;">Show more</p>
            </a>
          </div>
          <div>
          </div>

        </div>
      </div>
      <div class="details" id="additionalDetails">
        <div class="additional-details">
          <h2>Personal Details</h2>
          <ul>
            <li>Name: <?php echo $name ?></li>
            <li>Email: <?php echo $email ?></li>
            <li>Contact: <?php echo $contact ?></li>
            <li>Age: <?php echo $age ?></li>
            <li>Gender: <?php echo $gender ?></li>
            <li>Tech Stack: <?php echo $tech_stack ?></li>
            <li>Experience: <?php echo $experience ?></li>
            <li>Resume: <a href="../uploads/resume/<?php echo $resume ?>" target="_blank">View Resume</a></li>
            <li>Address: <?php echo $address . ", " . $city . ", " . $state . " (" . $pin . ")" ?></li>
          </ul>
          <a href="edit_profile.php?id=<?php echo $id ?>">
            <button class="edit-details-button">Edit Details</button>
          </a>
        </div>
      </div>
      </div>


      </div>
      <!-- END EDMO HTML (Happy Coding!)-->
    </main>
    <?php include('../includes/footer.php'); ?>
  </section>

  <!-- Script JS -->
  <script src="./js/script.js"></script>
  <!--$%analytics%$-->
  <script>
    function toggleDetails() {
      var additionalDetails = document.getElementById('additionalDetails');
      var button = document.getElementById('toggleButton');

      if (additionalDetails.style.display === 'none' || additionalDetails.style.display === '') {
        additionalDetails.style.display = 'block';
        button.innerText = 'Show less';
      } else {
        additionalDetails.style.display = 'none';
        button.innerText = 'Show more';
      }
    }
  </script>
  <script>
// Toggle the button state on click
document.querySelector('.toggle-button').addEventListener('click', function() {
  this.classList.toggle('toggle-on');
  this.classList.toggle('toggle-off');
});
</script>
  <?php include('../includes/script.php'); ?>

</body>

</html>