function toggleMobileDropdown(dropdownId) {
  const dropdown = document.getElementById(dropdownId);
  const buttonId = dropdownId.replace('mobileDropdownNavbar', 'mobileDropdownNavbarLink');
  const icon = document.getElementById(buttonId + 'Icon');
  
  dropdown.classList.toggle('open');
  icon.classList.toggle('rotate-180');
}

console.log('HELLO');

function toggleDropdown(id) {
  const element = document.getElementById(id);
  element.classList.toggle('hidden');
}
