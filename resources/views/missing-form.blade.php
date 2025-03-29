<x-layout>
  <!-- ========== START OF SECTION ========== -->
  <section class="flex flex-col gap-x-4 md:flex-row min-h-screen pt-10">
    <!-- Left Side: Full-Screen Image -->
    <div class="w-full md:w-1/2">
      <img src="{{ asset('images/black-dog.jpg') }}" alt="Missing Pet" class="w-full h-full object-cover" />
    </div>

    <!-- Right Side: Form -->
    <div class="w-full md:w-1/2 flex justify-start items-center px-2 pt-6 sm:p-8">
      <div class="max-w-md w-full">
        <h2 class="text-3xl font-bold text-orange-400 mb-6 text-left">
          Report a Missing Pet
        </h2>
        <form action="#" method="POST">
          <div class="space-y-4 mb-12">
            <div>
              <label class="block text-gray-700 font-medium">Pet's Name</label>
              <input type="text" placeholder="Enter pet's name"
                class="w-full p-3 border rounded-md focus:border-orange-500" required />
            </div>

            <div>
              <label class="block text-gray-700 font-medium">Owner's Name</label>
              <input type="text" placeholder="Enter owner's name"
                class="w-full p-3 border rounded-md focus:border-orange-500" required />
            </div>

            <div>
              <label class="block text-gray-700 font-medium">Owner's Contact No.</label>
              <input type="tel" placeholder="Enter contact number"
                class="w-full p-3 border rounded-md focus:border-orange-500" required />
            </div>

            <div>
              <label class="block text-gray-700 font-medium">Last Seen Date</label>
              <input type="date" class="w-full p-3 border rounded-md focus:border-orange-500" required />
            </div>

            <div>
              <label class="block text-gray-700 font-medium">Last Seen Location</label>
              <input type="text" placeholder="Enter last seen location"
                class="w-full p-3 border rounded-md focus:border-orange-500" required />
            </div>

            <div>
              <label class="block text-gray-700 font-medium">Upload Pet's Photo or Missing Poster</label>
              <input type="file"
                class="w-full py-0 border rounded-md focus:border-orange-500 file:bg-gray-400 file:border-0 file:text-white"
                required />
            </div>
          </div>

          <button type="submit"
            class="w-full bg-orange-500 text-white font-medium py-3 rounded-md hover:bg-yellow-500 transition">
            Submit Report
          </button>
        </form>
      </div>
    </div>
  </section>
  <!-- ========== END OF SECTION ========== -->
</x-layout>