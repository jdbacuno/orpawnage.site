<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="h-auto sm:h-screen mt-14 sm:mt-auto flex items-center bg-gray-100">
    <div class="grid grid-cols-1 md:grid-cols-2 w-full h-full">
      <!-- LEFT SIDE: Pet Image -->
      <div class="h-full w-full overflow-hidden hidden sm:block">
        <img src="{{ asset('images/surrender.jpg') }}" alt="Adopt a Pet" class="w-full h-full object-cover" />
      </div>

      <!-- RIGHT SIDE: Slogan and CTA -->
      <div class="bg-yellow-200 flex flex-col justify-center items-start p-10 sm:p-20">
        <h1 class="text-4xl sm:text-6xl font-extrabold text-gray-900 leading-tight">
          Can't take care of your pet? In possession of a wild or stray animal? Surrender them to our care!
        </h1>
        <!-- <p class="mt-4 text-lg text-gray-600">
          Find your pet a new family to love.
        </p>
        <a
          href="adopt.html"
          class="mt-6 inline-block bg-orange-500 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-yellow-500 transition-all duration-300"
        >
          View Adoptable Pets
        </a> -->
      </div>
    </div>
  </section>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START OF RESPONSIVE TEXT SECTION ========== -->
  <section class="bg-orange-700 text-white py-16 px-6 sm:px-10">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-3xl md:text-5xl font-bold text-left">
        Rehome a pet. In possesion of a wild or stray animal?
      </h2>
      <p class="mt-6 text-lg sm:text-xl/10 text-justify">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur
        commodi, architecto doloremque aliquid adipisci autem quis. Porro
        voluptates qui est reiciendis necessitatibus veritatis earum tempore
        ut iste. Voluptas, excepturi earum eaque ipsam odio voluptatibus sed
        quos aut eligendi recusandae doloribus! Lorem ipsum dolor sit, amet
        consectetur adipisicing elit. Perferendis cumque cupiditate aliquam
        eveniet dolor obcaecati.
      </p>
    </div>
  </section>
  <!-- ========== END OF RESPONSIVE TEXT SECTION ========== -->

  <!-- ========== START OF SURRENDER REQUEST FORM SECTION ========== -->
  <section class="py-10 px-1 md:px-20 lg:px-32 xl:px-40 relative overflow-hidden" id="surrenderForm">
    <div class="rounded-xl bg-gray-50 border border-gray-300 p-6 shadow-md">
      <h2 class="text-2xl sm:text-3xl font-bold text-left sm:text-center text-black mb-8">
        Surrender Request Form
      </h2>

      <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
        <!-- Left Side: Surrenderer's Info -->
        <div class="space-y-2">
          <h3 class="text-xl font-bold text-gray-800 mb-2">
            Surrenderer's Information
          </h3>

          <div>
            <label for="surrenderer-name" class="block text-gray-700 font-semibold mb-1">
              Surrenderer's Name
            </label>
            <input type="text" id="surrenderer-name" name="surrenderer_name" placeholder="Enter your full name"
              class="w-full p-3 border rounded-md shadow-sm focus:border-orange-500" required />
          </div>

          <div>
            <label for="address" class="block text-gray-700 font-semibold mb-1">
              Address
            </label>
            <input type="text" id="address" name="address" placeholder="Enter your address"
              class="w-full p-3 border rounded-md shadow-sm focus:border-orange-500" required />
          </div>

          <div>
            <label for="contact" class="block text-gray-700 font-semibold mb-1">
              Contact No.
            </label>
            <input type="tel" id="contact" name="contact_no" placeholder="Enter your contact number"
              class="w-full p-3 border rounded-md shadow-sm focus:border-orange-500" required />
          </div>
        </div>

        <!-- Divider for Mobile -->
        <div class="block md:hidden my-6 border-t border-gray-300"></div>

        <!-- Right Side: Pet Info -->
        <div class="space-y-2">
          <h3 class="text-xl font-bold text-gray-800 mb-2">
            Animal's Information
          </h3>

          <div>
            <label for="name" class="block text-gray-700 font-semibold mb-1">
              Animal's Name (Optional)
            </label>
            <input type="text" id="name" name="name" placeholder="Enter the pet's name (Optional)"
              class="w-full p-3 border rounded-md shadow-sm focus:border-orange-500" />
          </div>

          <div>
            <label for="species" class="block text-gray-700 font-semibold mb-1">
              Species (Dog, Cat, etc.)
            </label>
            <input type="text" id="species" name="species" placeholder="Enter the species"
              class="w-full p-3 border rounded-md shadow-sm focus:border-orange-500" required />
          </div>

          <div>
            <label for="breed" class="block text-gray-700 font-semibold mb-1">
              Breed
            </label>
            <input type="text" id="breed" name="breed" placeholder="Enter the breed (optional)"
              class="w-full p-3 border rounded-md shadow-sm focus:border-orange-500" />
          </div>

          <div>
            <label for="sex" class="block text-gray-700 font-semibold mb-1">
              Sex
            </label>
            <select id="sex" name="sex" class="w-full p-3 border rounded-md shadow-sm focus:border-orange-500" required>
              <option value="" disabled selected>Select the sex</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Unknown">Unknown</option>
            </select>
          </div>

          <div>
            <label for="reason" class="block text-gray-700 font-semibold mb-1">
              Reason for Surrendering
            </label>
            <textarea id="reason" name="reason" placeholder="Explain the reason"
              class="w-full p-3 border rounded-md shadow-sm focus:border-orange-500" rows="3" required></textarea>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="col-span-1 md:col-span-2 flex justify-center md:justify-end mt-8">
          <button type="submit"
            class="bg-orange-500 text-white font-semibold py-3 px-12 rounded-lg shadow-md hover:bg-yellow-500 hover:text-black transition-all duration-300 w-full md:w-auto">
            Submit Request
          </button>
        </div>
      </form>
    </div>

  </section>
  <!-- ========== END OF SURRENDER REQUEST FORM SECTION ========== -->
</x-layout>