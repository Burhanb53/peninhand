<style>
    ul.submenu {
        display: none;
        transition: max-height 0.3s ease-in-out;
        max-height: 0;
        overflow: hidden;
    }

    .submenu.open {
        display: block;
        max-height: 1000px; /* Adjust based on your content height */
    }
</style>

<nav class="sidebar">
    <div class="logo d-flex justify-content-between">
        <a href><img src="img/logo.png" alt></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">
        <li <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="mm-active"'; ?>>
            <a href="index.php" aria-expanded="false">
                <img src="img/menu-icon/dashboard.svg" alt>
                <span>Dashboard</span>
            </a>
        </li>
        <li <?php if (
            basename($_SERVER['PHP_SELF']) == 'all_teacher.php' ||
            basename($_SERVER['PHP_SELF']) == 'assign.php' ||
            basename($_SERVER['PHP_SELF']) == 'assign_teacher.php' ||
            basename($_SERVER['PHP_SELF']) == 'manage_teacher.php'
        ) echo 'class="mm-active"'; ?>>
            <a class="has-arrow" href="#" aria-expanded="false" onclick="toggleSubMenu(this)">
                <img src="img/menu-icon/2.svg" alt>
                <span>Teachers</span>
            </a>
            <ul class="submenu">
                <li><a href="all_teacher.php">All Teachers</a></li>
                <li><a href="assign.php">Assign</a></li>
                <li><a href="manage_teacher.php">Manage</a></li>
            </ul>
        </li>
        <li <?php if (
            basename($_SERVER['PHP_SELF']) == 'all_student.php' ||
            basename($_SERVER['PHP_SELF']) == 'manage_student.php' ||
            basename($_SERVER['PHP_SELF']) == 'doubts.php'
        ) echo 'class="mm-active"'; ?>>
            <a class="has-arrow" href="#" aria-expanded="false" onclick="toggleSubMenu(this)">
                <img src="img/menu-icon/3.svg" alt>
                <span>Students</span>
            </a>
            <ul class="submenu">
                <li><a href="all_student.php">All Students</a></li>
                <li><a href="manage_student.php">Manage</a></li>
                <li><a href="doubts.php">Doubts</a></li>
            </ul>
        </li>
    </ul>
</nav>

<script>
    function toggleSubMenu(element) {
        var submenu = element.nextElementSibling;
        submenu.classList.toggle('open');
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var submenus = document.querySelectorAll(".has-arrow");

        submenus.forEach(function(menu) {
            menu.addEventListener("click", function(e) {
                e.preventDefault();
                var submenu = this.nextElementSibling;
                submenu.style.display = (submenu.style.display === "block") ? "none" : "block";
            });
        });
    });
</script>