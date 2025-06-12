// Select all alert containers and buttons dynamically
document.addEventListener("DOMContentLoaded", function () {
    const alertElements = document.querySelectorAll("[id^=alert-]"); // Select all alerts that start with "alert-"
    const dismissButtons = document.querySelectorAll(".dismiss-btn"); // Select all dismiss buttons

    setTimeout(() => {
        document.querySelector(alertId).remove(); // Remove after animation
    }, 2000);

    dismissButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const alertId = button.getAttribute("data-dismiss-target"); // Get target alert ID
            const alertEl = document.querySelector(alertId);

            if (alertEl) {
                alertEl.classList.add("opacity-0"); // Fade out effect
                setTimeout(() => {
                    alertEl.remove(); // Remove after animation
                }, 500);
            }
        });
    });
});

