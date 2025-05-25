const logoutBtn = document.getElementById("logoutBtn");

    logoutBtn.style.cursor = "pointer"; // Make it look clickable

    logoutBtn.addEventListener("click", function () {
      window.location.href = "logout.php"; // Redirect to logout
    });