document.addEventListener("DOMContentLoaded", function() {
    var searchInput = document.getElementById("searchInput");

    searchInput.addEventListener("input", function() {
        var query = this.value.toLowerCase().trim();
        var chatCards = document.querySelectorAll("#searchResults .chat-card");

        chatCards.forEach(function(card) {
            var messageText = card.querySelector(".message-text").textContent.toLowerCase();

            if (messageText.includes(query)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});

function handleRightIconClick() {
    // Add your logic for right icon click here
    console.log('Right icon clicked');
}