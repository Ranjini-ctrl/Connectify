let typingTimer;

const input = document.getElementById("messageInput");

input.addEventListener("input", () => {

    // Start typing
    fetch("../api/update_typing.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "typing=1"
    });

    clearTimeout(typingTimer);

    // Stop typing after 1.5 sec
    typingTimer = setTimeout(() => {
        fetch("../api/update_typing.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "typing=0"
        });
    }, 1500);
});


// Check other user typing
setInterval(() => {
    fetch("../api/get_typing.php")
    .then(res => res.text())
    .then(data => {
        const typingDiv = document.getElementById("typing-status");

        if (data !== "") {
            typingDiv.innerHTML = "<span class='typing'>" + data + "</span>";
        } else {
            typingDiv.innerHTML = "";
        }
    });
}, 800);