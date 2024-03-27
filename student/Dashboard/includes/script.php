<script src="../js/jquery1-3.4.1.min.js"></script>

    <script src="../js/popper1.min.js"></script>

    <script src="../js/bootstrap1.min.js"></script>

    <script src="../js/metisMenu.js"></script>

    <script src="../vendors/count_up/jquery.waypoints.min.js"></script>

    <script src="../vendors/chartlist/Chart.min.js"></script>

    <script src="../vendors/count_up/jquery.counterup.min.js"></script>

    <script src="../vendors/swiper_slider/js/swiper.min.js"></script>

    <script src="../vendors/niceselect/js/jquery.nice-select.min.js"></script>

    <script src="../vendors/owl_carousel/js/owl.carousel.min.js"></script>

    <script src="../vendors/gijgo/gijgo.min.js"></script>

    <script src="../vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatable/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatable/js/jszip.min.js"></script>
    <script src="../vendors/datatable/js/pdfmake.min.js"></script>
    <script src="../vendors/datatable/js/vfs_fonts.js"></script>
    <script src="../vendors/datatable/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatable/js/buttons.print.min.js"></script>

    <script src="../vendors/datepicker/datepicker.js"></script>
    <script src="../vendors/datepicker/datepicker.en.js"></script>
    <script src="../vendors/datepicker/datepicker.custom.js"></script>
    <script src="../js/chart.min.js"></script>

    <script src="../vendors/progressbar/jquery.barfiller.js"></script>

    <script src="../vendors/tagsinput/tagsinput.js"></script>
    <script src="../vendors/chart_am/core.js"></script>
    <script src="../vendors/chart_am/charts.js"></script>
    <script src="../vendors/chart_am/animated.js"></script>
    <script src="../vendors/chart_am/kelly.js"></script>
    <script src="../vendors/chart_am/chart-custom.js"></script>

    <script src="../js/custom.js"></script>
    <script src="../vendors/apex_chart/bar_active_1.js"></script>
    <script src="../vendors/apex_chart/apex_chart_list.js"></script>
    
    <script>
        // Counter Animation
        document.addEventListener("DOMContentLoaded", function () {
            const counters = document.querySelectorAll('.count');
            const speed = 100; // The lower the slower

            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-count');
                    const count = +counter.innerText;

                    // Lower inc to slow and higher to slow
                    const inc = target / speed;

                    // Check if target is reached
                    if (count < target) {
                        // Add inc to count and output in counter
                        counter.innerText = Math.ceil(count + inc);
                        // Call function every ms
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });
        });
    </script>