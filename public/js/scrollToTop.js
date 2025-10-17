document.addEventListener("DOMContentLoaded", function () {
  const scrollToTopBtn = document.getElementById("scrollToTop");
  const bugReport = document.getElementById("bug-report-container");
  const gapPx = 8; // desired gap between buttons when both visible

  window.addEventListener("scroll", function () {
    if (window.scrollY > 300) {
      scrollToTopBtn.classList.remove("hidden");
      if (bugReport) {
        const sttStyles = window.getComputedStyle(scrollToTopBtn);
        const sttBottom = parseInt(sttStyles.bottom) || 32; // Tailwind bottom-8 ≈ 32px
        const sttHeight = scrollToTopBtn.offsetHeight || 48; // w-12 h-12 ≈ 48px
        bugReport.style.bottom = (sttBottom + sttHeight + gapPx) + "px";
      }
    } else {
      scrollToTopBtn.classList.add("hidden");
      if (bugReport) {
        const sttStyles = window.getComputedStyle(scrollToTopBtn);
        const sttBottom = parseInt(sttStyles.bottom) || 32; // align with scroll button's initial position
        bugReport.style.bottom = sttBottom + "px";
      }
    }
  });

  scrollToTopBtn.addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});