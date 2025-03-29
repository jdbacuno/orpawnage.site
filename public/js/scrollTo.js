document.addEventListener("DOMContentLoaded", function () {
  if (window.location.pathname === "/services/adopt-a-pet") {
      const section = document.getElementById("pets");
      if (section) {
          section.scrollIntoView({ behavior: "smooth" });
      }
  }
});

document.addEventListener("DOMContentLoaded", function () {
  if (window.location.pathname === "/services/surrender-an-animal") {
      const section = document.getElementById("surrenderForm");
      if (section) {
          section.scrollIntoView({ behavior: "smooth" });
      }
  }
});