document.getElementById("upload").addEventListener("change", function (event) {
  const fileInput = event.target;
  const filePreview = document.getElementById("filePreview");

  while (filePreview.firstChild) {
    filePreview.removeChild(filePreview.firstChild);
  }

  if (fileInput.files.length > 0) {
    const file = fileInput.files[0];
    const filePreviewContainer = document.createElement("div");

    if (file.type.startsWith("image/")) {
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      filePreviewContainer.appendChild(img);
    } else {
      const link = document.createElement("a");
      link.href = URL.createObjectURL(file);
      link.textContent = file.name;
      link.target = "_blank";
      filePreviewContainer.appendChild(link);
    }

    filePreview.appendChild(filePreviewContainer);
  }
});

// Get the card content element
var cardContent = document.querySelector(".message-container");

// Add the class to make it invisible after 3 seconds
setTimeout(function () {
  cardContent.classList.add("invisible");
}, 3000);
