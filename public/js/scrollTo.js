document.addEventListener("DOMContentLoaded", function () {
  if (window.location.pathname === "/services/adopt-a-pet") {
      const section = document.getElementById("pets");
      if (section) {
          section.scrollIntoView({ behavior: "smooth" });
      }
  }
});