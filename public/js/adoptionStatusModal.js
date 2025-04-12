// Pet Info Modal
document.addEventListener('DOMContentLoaded', function () {
  const petInfoModal = document.getElementById('petInfoModal');
  const closePetInfoModal = document.getElementById('closePetInfoModal');

  document.querySelectorAll(".pet-info-btn").forEach(button => {
    button.addEventListener("click", function() {
        const image = this.getAttribute("data-image");
        const number = this.getAttribute("data-number");
        const name = this.getAttribute("data-name");
        const species = this.getAttribute("data-species");
        const age = this.getAttribute("data-age");
        const ageUnit = this.getAttribute("data-age-unit");
        const color = this.getAttribute("data-color");
        const source = this.getAttribute("data-source");
        const sex = this.getAttribute("data-sex");
        const reproductiveStatus = this.getAttribute("data-repro-status");

        // Make the unit singular if age is 1
        const ageUnitSingular = (age === 1) ? (ageUnit === "weeks" ? "week" : (ageUnit === "months" ? "month" : "year")) : ageUnit;
        
        document.getElementById("petImage").src = image;
        document.getElementById("petNumber").textContent = number;
        document.getElementById("petName").textContent = name;
        document.getElementById("petSpecies").textContent = species;
        document.getElementById("petAge").textContent = age;
        document.getElementById("petAgeUnit").textContent = ageUnitSingular;
        document.getElementById("petColor").textContent = color;
        document.getElementById("petSource").textContent = source;
        document.getElementById("petSex").textContent = sex;
        document.getElementById("petReproStatus").textContent = reproductiveStatus;

        petInfoModal.classList.remove("hidden");
    });
  });

  closePetInfoModal.addEventListener('click', function () {
      petInfoModal.classList.add('hidden');
  });

});

// Adopter Info Modal
document.addEventListener('DOMContentLoaded', function () {
  const adopterInfoModal = document.getElementById('adopterInfoModal');
  const closeAdopterInfoModal = document.getElementById('closeAdopterInfoModal');
  
  document.querySelectorAll(".adopter-info-btn").forEach(button => {
    button.addEventListener("click", function() {
        const name = this.getAttribute("data-name");
        const email = this.getAttribute("data-email");
        const age = this.getAttribute("data-age");
        const birthdate = this.getAttribute("data-birthdate");
        const address = this.getAttribute("data-address");
        const phone = this.getAttribute("data-phone");
        const civilStatus = this.getAttribute("data-civil");
        const citizenship = this.getAttribute("data-citizenship");
  
        document.getElementById("adopterName").textContent = name;
        document.getElementById("adopterEmail").textContent = email;
        document.getElementById("adopterAge").textContent = age;
        document.getElementById("adopterBirthdate").textContent = birthdate;
        document.getElementById("adopterAddress").textContent = address;
        document.getElementById("adopterPhone").textContent = phone;
        document.getElementById("adopterCivilStatus").textContent = civilStatus;
        document.getElementById("adopterCitizenship").textContent = citizenship;
  
        document.getElementById("adopterInfoModal").classList.remove("hidden");
    });
  });
  
  closeAdopterInfoModal.addEventListener('click', function () {
      adopterInfoModal.classList.add('hidden');
  });
});