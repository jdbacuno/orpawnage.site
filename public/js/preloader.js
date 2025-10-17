document.addEventListener('DOMContentLoaded', function() {
  const preloader = document.getElementById('preloader');
  const mainContent = document.getElementById('main-content');
  
  // Check if this is the first visit ever (using localStorage)
  if (localStorage.getItem('preloaderShown')) {
    // Not the first visit - skip preloader
    preloader.style.display = 'none';
    mainContent.classList.remove('hidden');
  } else {
    // First visit ever - show preloader and set flag
    localStorage.setItem('preloaderShown', 'true');
    
    // Hide preloader when page is fully loaded
    window.addEventListener('load', function() {
      preloader.style.display = 'none';
      mainContent.classList.remove('hidden');
    });
  }
});
