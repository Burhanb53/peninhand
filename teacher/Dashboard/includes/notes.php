<style>
    .CHAT_MESSAGE_POPUPBOX::-webkit-scrollbar {
        width: 6px;
    }

    .CHAT_MESSAGE_POPUPBOX::-webkit-scrollbar-thumb {
        background-color: #B9BABA;
        border-radius: 6px;
    }

    .CHAT_MESSAGE_POPUPBOX::-webkit-scrollbar-track {
        background-color: #f5f5f5;
    }

    .note-card {
        border: 1px solid #ccc;
        border-radius: 10px;
        margin: 20px;
        overflow: hidden;
    }

    .note-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .note-header h2 {
        margin: 0;
        font-size: 18px;
    }

    .note-header p {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
        /* Adjust spacing */
    }

    .options {
        position: relative;
    }

    .options-list {
        position: absolute;
        top: calc(100% + 5px);
        right: 0;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        padding: 0;
        max-height: 100px;
        overflow-y: auto;
        z-index: 100;
        display: none;
        margin-top: 10px;
        /* Adjust this value as needed */
    }

    .options-list li {
        list-style-type: none;
        padding: 8px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
        z-index: 100;
        overflow-y: auto;

    }

    .options-list li:hover {
        background-color: #f0f0f0;
    }

    .note-content {
        padding: 10px;
        display: none;
        min-height: 100px;
        white-space: pre-line; /* Preserve line breaks */

    }

    .note-card.open .note-content {
        display: block;
    }

    .dot-menu {
        width: 30px;
        height: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .dot {
        width: 6px;
        height: 6px;
        background-color: #333;
        border-radius: 50%;
    }

    .show {
        display: block !important;
    }



    .note-card.open .note-content {
        display: block;
    }

    .add-note-button {
        margin-left: auto;
        /* Pushes the add button to the right */
        padding: 5px;
        border: none;
        background-color: white;
        border-radius: 5px;
        cursor: pointer;

    }

    .add-note-button svg {
        width: 24px;
        height: 24px;
        fill: red;

    }

    .add-note-button:hover {
        background-color: #f5f5f5;
    }
</style>
<style>
    .new-note-card {
        width: auto;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 10px;
    }

    .note-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .new-note-content {
        border: none;
        width: 100%;
        height: 200px;
        padding: 10px;
        background-image: repeating-linear-gradient(180deg, transparent, transparent 2px, #F1F1F1 2px, #F1F1F1 8px);
        font-family: Arial, sans-serif;
        font-size: 16px;
        resize: none;
    }

    .note-button {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .doubt {
        margin-top: 20px;
        width: auto;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color:blue !important;
    }

    .doubt-field {
        margin-top: 10px;
    }

    .doubt-value {
        display: inline-block;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        pointer-events: none;
        /* Prevent clicking on the input */
    }

    .remove-field-button {
        margin-left: 10px;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        cursor: pointer;
    }
</style>


<div class="CHAT_MESSAGE_POPUPBOX" style="height: 90%; overflow-y:scroll">
    <div class="CHAT_POPUP_HEADER">
        <div class="MSEESAGE_CHATBOX_CLOSE">
            <!-- Close button SVG -->
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.09939 5.98831L11.772 10.661C12.076 10.965 12.076 11.4564 11.772 11.7603C11.468 12.0643 10.9766 12.0643 10.6726 11.7603L5.99994 7.08762L1.32737 11.7603C1.02329 12.0643 0.532002 12.0643 0.228062 11.7603C-0.0760207 11.4564 -0.0760207 10.965 0.228062 10.661L4.90063 5.98831L0.228062 1.3156C-0.0760207 1.01166 -0.0760207 0.520226 0.228062 0.216286C0.379534 0.0646715 0.578697 -0.0114918 0.777717 -0.0114918C0.976738 -0.0114918 1.17576 0.0646715 1.32737 0.216286L5.99994 4.889L10.6726 0.216286C10.8243 0.0646715 11.0233 -0.0114918 11.2223 -0.0114918C11.4213 -0.0114918 11.6203 0.0646715 11.772 0.216286C12.076 0.520226 12.076 1.01166 11.772 1.3156L7.09939 5.98831Z" fill="white" />
            </svg>
        </div>
        <div style="display: flex; align-items: center;">
            <h2>Notes</h2>
            <button class="add-note-button" style="margin-left: 10px;" onclick="openNoteCard()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5 12H19" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>



    <div class="CHAT_POPUP_BOTTOM">
        <div class="new-note-card" id="noteCard" style="display: none;">
            <div class="close-note" style="margin-bottom: 10px; float: inline-end;" onclick="openNoteCard()">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="black" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.09939 5.98831L11.772 10.661C12.076 10.965 12.076 11.4564 11.772 11.7603C11.468 12.0643 10.9766 12.0643 10.6726 11.7603L5.99994 7.08762L1.32737 11.7603C1.02329 12.0643 0.532002 12.0643 0.228062 11.7603C-0.0760207 11.4564 -0.0760207 10.965 0.228062 10.661L4.90063 5.98831L0.228062 1.3156C-0.0760207 1.01166 -0.0760207 0.520226 0.228062 0.216286C0.379534 0.0646715 0.578697 -0.0114918 0.777717 -0.0114918C0.976738 -0.0114918 1.17576 0.0646715 1.32737 0.216286L5.99994 4.889L10.6726 0.216286C10.8243 0.0646715 11.0233 -0.0114918 11.2223 -0.0114918C11.4213 -0.0114918 11.6203 0.0646715 11.772 0.216286C12.076 0.520226 12.076 1.01166 11.772 1.3156L7.09939 5.98831Z" fill="black" />
                </svg>
            </div>
            <input type="text" class="note-title" placeholder="Title" required>
            <textarea class="new-note-content" placeholder="Write your notes here..." required></textarea>
            <!-- doubt field -->
            <?php if ($page_url === 'chat.php') { ?>
                <div class="doubt-field" style="display:flex">
                    <input type="text" class="doubt-value" value="<?php echo  $doubt_id; ?>" placeholder=" : <?php echo $doubt_message; ?>" disabled>
                    <button class="remove-field-button" onclick="removeNonEditableField()">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="black" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.09939 5.98831L11.772 10.661C12.076 10.965 12.076 11.4564 11.772 11.7603C11.468 12.0643 10.9766 12.0643 10.6726 11.7603L5.99994 7.08762L1.32737 11.7603C1.02329 12.0643 0.532002 12.0643 0.228062 11.7603C-0.0760207 11.4564 -0.0760207 10.965 0.228062 10.661L4.90063 5.98831L0.228062 1.3156C-0.0760207 1.01166 -0.0760207 0.520226 0.228062 0.216286C0.379534 0.0646715 0.578697 -0.0114918 0.777717 -0.0114918C0.976738 -0.0114918 1.17576 0.0646715 1.32737 0.216286L5.99994 4.889L10.6726 0.216286C10.8243 0.0646715 11.0233 -0.0114918 11.2223 -0.0114918C11.4213 -0.0114918 11.6203 0.0646715 11.772 0.216286C12.076 0.520226 12.076 1.01166 11.772 1.3156L7.09939 5.98831Z" fill="black" />
                        </svg>
                    </button>
                </div>
            <?php } ?>
            <button class="note-button">Add</button>
        </div>

        <?php
        session_start();
        // Establish database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "peninhand";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch note data from the database
        // Assuming user_id is obtained from session (replace 1 with actual user_id)
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT n.id, n.title, n.content, n.doubt_id, n.created_at, d.doubt 
        FROM notes n
        LEFT JOIN doubt d ON n.doubt_id = d.doubt_id
        WHERE n.user_id = $user_id  
        ORDER BY n.created_at DESC";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="note-card" data-note-id="' . $row["id"] . '">';
                echo '<div class="note-header">';
                echo '<div>
                         <h2>' . $row["title"] . '</h2>
                        <p>' . date("h:i A d/m/y ", strtotime($row["created_at"])) . '</p>
                    </div>';
                echo '<div class="options">';
                echo '<div class="dot-menu">';
                echo '<div class="dot"></div>';
                echo '<div class="dot"></div>';
                echo '<div class="dot"></div>';
                echo '</div>';
                echo '<ul class="options-list">';
                echo '<li class="edit-note" data-note-id="' . $row["id"] . '">Edit</li>'; // Add data-note-id attribute
                echo '<li class="delete-note" data-note-id="' . $row["id"] . '">Delete</li>'; // Add data-note-id attribute
                echo '</ul>';
                echo '</div>';
                echo '</div>';
                echo '<div class="note-content">';
                echo '<p>' . nl2br($row["content"]) . '</p>'; // Use nl2br() to convert newlines to <br> tags
                $current_page = basename($_SERVER['PHP_SELF']);
                $is_index_page = ($current_page === 'index.php');

                if ($row["doubt_id"] != null) {
                    // Check if the current page is index.php
                    if ($is_index_page) {
                        echo '<div class="doubt" ><a href="Pages/chat.php?doubt_id=' . $row['doubt_id'] . '">';
                    } else {
                        echo '<div class="doubt"><a href="chat.php?doubt_id=' . $row['doubt_id'] . '">';
                    }
                    echo '<h7  style="color:blue; !important">' . substr($row["doubt"], 0, 40) . '</h7>';
                    echo '</a></div>';
                }

                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div style="text-align:center; margin-top:20px;" >';
            echo "No notes found.";
            echo '</div>';
        }


        $conn->close();
        ?>


    </div>
</div>
<script>
    document.querySelectorAll('.note-header').forEach(header => {
        header.addEventListener('click', () => {
            header.parentNode.classList.toggle('open');
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dotMenus = document.querySelectorAll('.dot-menu');
        const optionsLists = document.querySelectorAll('.options-list');

        dotMenus.forEach((dotMenu, index) => {
            dotMenu.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevents the click event from propagating to the parent .note-header
                optionsLists[index].classList.toggle('show');
            });
        });

        // Close options list when clicking outside
        document.addEventListener('click', (event) => {
            optionsLists.forEach(optionsList => {
                if (!optionsList.contains(event.target)) {
                    optionsList.classList.remove('show');
                }
            });
        });
    });
</script>
<script>
    function openNoteCard() {
        var noteCard = document.getElementById("noteCard");
        noteCard.style.display = (noteCard.style.display === "none") ? "block" : "none";
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to handle adding a new note
    function addNote() {
        // Retrieve title, content, and doubt value from input fields
        var title = $(".note-title").val();
        var content = $(".new-note-content").val();
        var doubtValue = $(".doubt-value").val(); // Add this line

        // Check if title and content are not empty
        if (title.trim() === "" || content.trim() === "") {
            alert("Please enter a title and content for the note.");
            return;
        }

        // Create data object to send in the AJAX request
        var data = {
            title: title,
            content: content,
            doubt_id: doubtValue // Add this line
        };

        // Send AJAX POST request to the backend
        $.ajax({
            type: "POST",
            url: "<?php echo $is_index_page ? 'backend/add_notes.php' : '../backend/add_notes.php'; ?>",
            data: JSON.stringify(data),
            contentType: "application/json",
            success: function(response) {
                // Handle successful response
                console.log(response);
                // Reload page
                location.reload();
                // Optionally, you can perform any action like displaying a success message or reloading the page
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
                alert("An error occurred while adding the note. Please try again later.");
            }
        });
    }


    // Function to handle updating an existing note
    function updateNote() {
        var noteId = $('#noteCard').data('note-id');

        // Retrieve updated title and content from input fields
        var updatedTitle = $(".note-title").val();
        var updatedContent = $(".new-note-content").val();

        // Check if updated title and content are not empty
        if (updatedTitle.trim() === "" || updatedContent.trim() === "") {
            alert("Please enter a title and content for the note.");
            return;
        }

        // Create data object to send in the AJAX request
        var data = {
            noteId: noteId,
            updatedTitle: updatedTitle,
            updatedContent: updatedContent
        };

        // Send AJAX POST request to the backend
        $.ajax({
            type: "POST",
            url: "<?php echo $is_index_page ? 'backend/update_notes.php' : '../backend/update_notes.php'; ?>",
            data: JSON.stringify(data),
            contentType: "application/json",
            success: function(response) {
                // Handle successful response
                console.log(response);
                // Reload page or perform any other action as needed
                location.reload();
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
                alert("An error occurred while updating the note. Please try again later.");
            }
        });
    }


    $(document).ready(function() {
        // Click event handler for the "Add" button
        $('.add-note-button').click(function() {
            $('#noteCard').show();
        });

        // Click event handler for the "Edit" button
        $('.edit-note').click(function() {
            var noteId = $(this).data('note-id');
            var title = $(this).closest('.note-card').find('.note-header h2').text();
            var content = $(this).closest('.note-card').find('.note-content p').text();

            // Populate the form fields with existing note details
            $('#noteCard').find('.note-title').val(title);
            $('#noteCard').find('.new-note-content').val(content);
            $('#noteCard').find('.note-button').text('Update'); // Change button text to "Update"
            $('#noteCard').data('note-id', noteId); // Store note ID in the form data attribute
            $('#noteCard').show(); // Show the edit form
        });

        // Click event handler for the "Add" or "Update" button inside the note card
        $('.note-button').click(function() {
            if ($(this).text() === 'Add') {
                addNote();
            } else if ($(this).text() === 'Update') {
                updateNote();
            }
        });
    });



    $(document).ready(function() {
        $('.edit-note').click(function() {
            var noteId = $(this).data('note-id');
            var title = $(this).closest('.note-card').find('.note-header h2').text();
            var content = $(this).closest('.note-card').find('.note-content p').text();

            // Populate the form fields with existing note details
            $('#noteCard').find('.note-title').val(title);
            $('#noteCard').find('.new-note-content').val(content);
            $('#noteCard').find('.note-button').text('Update'); // Change button text to "Update"
            $('#noteCard').data('note-id', noteId); // Store note ID in the form data attribute
            $('#noteCard').show(); // Show the edit form
        });
    });



    // Event listener for the "Delete" option click
    $(".delete-note").click(function(event) {
        event.preventDefault(); // Prevent the default action of the anchor
        var noteId = $(this).data("note-id"); // Get the note ID from the data-note-id attribute
        if (confirm("Are you sure you want to delete this note?")) {
            window.location.href = "<?php echo $is_index_page ? 'backend/delete_note.php' : '../backend/delete_note.php'; ?>" +
                "<?php echo $is_index_page ? '?' : '?'; ?>noteId=" + noteId; // Redirect to the delete endpoint
        }
    });

    function removeNonEditableField() {
        var fieldToRemove = document.querySelector('.doubt-field');
        if (fieldToRemove) {
            fieldToRemove.remove();
        }
    }
</script>