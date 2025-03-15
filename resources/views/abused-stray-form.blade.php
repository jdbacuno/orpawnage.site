<x-layout>
  <!-- ========== START OF SECTION ========== -->
  <section class="flex flex-col md:flex-row gap-x-6 min-h-screen pt-10">
    <!-- Left Side: Form -->
    <div class="w-full md:w-1/2 flex justify-center items-center p-8">
      <div class="max-w-2xl w-full bg-white p-6">
        <h2 class="text-3xl font-bold text-orange-400 mb-6 text-left">
          Report an Incident of Abused/Stray Animal
        </h2>
        <form action="#" method="POST">
          <!-- Two-column layout for large screens -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Personal Info -->
            <div class="space-y-4">
              <h3 class="text-sm font-semibold text-gray-500 mb-1">
                Reporter's Information
              </h3>
              <div>
                <label class="block text-gray-700 font-medium"
                  >Reporter's Name (Optional)</label
                >
                <input
                  type="text"
                  placeholder="Fullname (optional)"
                  class="w-full p-3 border rounded-md focus:border-orange-500"
                />
              </div>
              <div>
                <label class="block text-gray-700 font-medium"
                  >Contact No.</label
                >
                <input
                  type="tel"
                  placeholder="Contact number"
                  class="w-full p-3 border rounded-md focus:border-orange-500"
                  required
                />
              </div>
              <div>
                <label class="block text-gray-700 font-medium"
                  >Location of Incident</label
                >
                <input
                  type="text"
                  placeholder="Location of Incident"
                  class="w-full p-3 border rounded-md focus:border-orange-500"
                  required
                />
              </div>
              <div>
                <label class="block text-gray-700 font-medium"
                  >Date of Incident</label
                >
                <input
                  type="date"
                  placeholder="Location of Incident"
                  class="w-full p-3 border rounded-md focus:border-orange-500"
                  required
                />
              </div>
            </div>

            <!-- Animal Info -->
            <div class="space-y-4">
              <h3 class="text-sm font-semibold text-gray-500 mb-1">
                Animal's Information
              </h3>
              <div>
                <label class="block text-gray-700 font-medium"
                  >Type of Animal</label
                >
                <input
                  type="text"
                  placeholder="e.g. dog, cat, monkey..."
                  class="w-full p-3 border rounded-md focus:border-orange-500"
                  required
                />
              </div>
              <div>
                <label class="block text-gray-700 font-medium"
                  >Condition of Animal</label
                >
                <input
                  type="text"
                  placeholder="Condition of Animal"
                  class="w-full p-3 border rounded-md focus:border-orange-500"
                  required
                />
              </div>
              <div>
                <label class="block text-gray-700 font-medium"
                  >Additional Notes</label
                >
                <textarea
                  placeholder="Additional notes"
                  class="w-full p-3 border rounded-md focus:border-orange-500"
                  required
                ></textarea>
              </div>
              <div>
                <label class="block text-gray-700 font-medium"
                  >Upload a Photo of Proof (if there's any)</label
                >
                <input
                  type="file"
                  class="w-full py-0 border rounded-md focus:border-orange-500 file:bg-gray-400 file:border-0 file:text-white"
                  required
                />
              </div>
            </div>
          </div>

          <!-- Submit button - Full width on mobile, right aligned on larger screens -->
          <div class="flex justify-center md:justify-end">
            <button
              type="submit"
              class="w-full md:w-auto bg-orange-400 text-white font-medium py-3 px-6 rounded-md hover:bg-yellow-500 transition"
            >
              Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Right Side: Full-Screen Image -->
    <div class="w-full md:w-1/2">
      <img
        src="{{ asset('images/black-dog.jpg') }}"
        alt="Missing Pet"
        class="w-full h-full object-cover"
      />
    </div>
  </section>
  <!-- ========== END OF SECTION ========== -->
</x-layout>