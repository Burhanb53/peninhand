function zoomMedia(element, mediaType) {
    var modal = document.getElementById('zoomModal');
    var zoomedContent = document.getElementById('zoomedContent');
    var downloadLink = document.getElementById('downloadLink');

    modal.style.display = 'block';
    zoomedContent.innerHTML = ''; // Clear previous content

    if (mediaType === 'image') {
        const img = document.createElement('img');
        img.src = element.src;
        zoomedContent.appendChild(img);

        // Set the href property of the download link for images
        downloadLink.href = element.src;
        downloadLink.style.display = 'block'; // Show download link for images
    } else if (mediaType === 'pdf' || mediaType === 'doc' || mediaType === 'docx') {
        // Display PDF in a new tab

        // Hide the download link for PDFs
        downloadLink.style.display = 'none';
    } else if (mediaType === 'video') {
        const video = document.createElement('video');
        video.src = element.querySelector('source').src;
        video.controls = true;
        video.width = '100%';
        video.height = 'auto';
        zoomedContent.appendChild(video);

        // Hide the download link for videos
        downloadLink.style.display = 'none';
    }
}


function closeZoom() {
    var modal = document.getElementById('zoomModal');
    modal.style.display = 'none';
}


function closeZoom() {
    var modal = document.getElementById('zoomModal');
    modal.style.display = 'none';
}

function goBack() {
    window.history.back();
}

function sendMessage() {
    // Add logic to send a message
}

function confirmReject() {
    return confirm('Are you sure you want to reject this doubt?');
}

function confirmAccept() {
    return confirm('Are you sure you want to accept this doubt?');
}

function confirmEnd() {
    return confirm('Are you sure you want to end this chat?');
}


function copyToClipboard(text) {
    // Create a temporary input element
    var tempInput = document.createElement("input");
    // Set the input element's value to the text to be copied
    tempInput.value = text;
    // Append the input element to the document
    document.body.appendChild(tempInput);
    // Select the text in the input element
    tempInput.select();
    // Copy the selected text to the clipboard
    document.execCommand("copy");
    // Remove the temporary input element from the document
    document.body.removeChild(tempInput);
    // Optionally, provide user feedback or perform other actions
    alert("Copied to clipboard: " + text);
}


function joinVideoCall(text) {
    var videoLink = text;
    // var joinCode = document.getElementById('joinCode').value;

    // Add your logic here to handle the video call link and join code
    // You can redirect or initiate the video call based on the provided information
    var confirmation = confirm('Joining video call:\nVideo Link: ' + videoLink + '\n\nAre you copied join code ? ');

    if (confirmation) {
        var searchUrl = 'https://www.google.com/search?q=' + encodeURIComponent(videoLink);

        // Open the search URL in a new tab
        window.open(searchUrl, '_blank');
    } else {
        // Cancelled
        alert('Video call join cancelled.');
    }
}