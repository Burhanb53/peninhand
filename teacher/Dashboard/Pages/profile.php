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
  </style>
</head>

<body>
  <?php include('../includes/sidebar.php'); ?>
  <section class="main_content dashboard_part">
    <?php include('../includes/navbar.php'); ?>
    <!--$%adsense%$-->
    <main class="cd__main">
      <!-- Start DEMO HTML (Use the following code into your project)-->
      <div class="profile-page">
        <div class="content">

          <div class="content__cover">
            <div class="content__avatar"></div>
            <div class="content__bull"><span></span><span></span><span></span><span></span><span></span>
            </div>
          </div>
          <div class="content__actions"><a href="video_call.php">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <path fill="currentColor"
                  d="M192 256A112 112 0 1 0 80 144a111.94 111.94 0 0 0 112 112zm76.8 32h-8.3a157.53 157.53 0 0 1-68.5 16c-24.6 0-47.6-6-68.5-16h-8.3A115.23 115.23 0 0 0 0 403.2V432a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48v-28.8A115.23 115.23 0 0 0 268.8 288z">
                </path>
                <path fill="currentColor"
                  d="M480 256a96 96 0 1 0-96-96 96 96 0 0 0 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592a48 48 0 0 0 48-48 111.94 111.94 0 0 0-112-112z">
                </path>
              </svg><span>Video Call</span></a><a href="ask_doubt.php">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path fill="currentColor"
                  d="M208 352c-41 0-79.1-9.3-111.3-25-21.8 12.7-52.1 25-88.7 25a7.83 7.83 0 0 1-7.3-4.8 8 8 0 0 1 1.5-8.7c.3-.3 22.4-24.3 35.8-54.5-23.9-26.1-38-57.7-38-92C0 103.6 93.1 32 208 32s208 71.6 208 160-93.1 160-208 160z">
                </path>
                <path fill="currentColor"
                  d="M576 320c0 34.3-14.1 66-38 92 13.4 30.3 35.5 54.2 35.8 54.5a8 8 0 0 1 1.5 8.7 7.88 7.88 0 0 1-7.3 4.8c-36.6 0-66.9-12.3-88.7-25-32.2 15.8-70.3 25-111.3 25-86.2 0-160.2-40.4-191.7-97.9A299.82 299.82 0 0 0 208 384c132.3 0 240-86.1 240-192a148.61 148.61 0 0 0-1.3-20.1C522.5 195.8 576 253.1 576 320z">
                </path>
              </svg><span>Ask Doubt</span></a></div>
          <div class="content__title">
            <h1>Samantha Jones</h1><span>New York, United States</span>
          </div>
          <ul class="content__list">
            <li><span>65</span>Doubts</li>
            <li><span>43</span>Answers</li>
            <li><span>21</span>Video Calls</li>
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
        <div class="additional-details" style="background-colour: red">
          <h2>Personal Details</h2>
          <ul>
            <li>Name: Samantha Jones</li>
            <li>Email: samantha@example.com</li>
            <li>Contact: +1234567890</li>
            <li>Address: New York, United States, 12345</li>
          </ul>

          <h2>Parent Details</h2>
          <ul>
            <li>Mother Name: Mary Jones</li>
            <li>Mother Email: mary@example.com</li>
            <li>Mother Contact: +1234567890</li>
            <li>Father Name: John Jones</li>
            <li>Father Email: john@example.com</li>
            <li>Father Contact: +1234567890</li>
          </ul>
          <a href="edit_profile.php">
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
</body>

</html>