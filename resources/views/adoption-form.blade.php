<x-layout>
  <!-- START OF THE SECTION -->
  <section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <h2 class="text-4xl font-bold text-black mt-6 mb-4">
        Adoption Request Form
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-2 overflow-hidden">
        <!-- LEFT SIDE: Pet Image -->
        <div class="h-full w-full">
          <img src="{{ asset('images/black-dog.jpg') }}" alt="Pet Image" class="w-full h-auto object-cover" />
        </div>

        <!-- RIGHT SIDE: Pet Details and User Information -->
        <div class="p-6">
          <!-- Pet Details -->
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Adopt Pet#1
          </h2>
          <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Species</label>
              <input type="text" value="Dog" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Breed</label>
              <input type="text" value="Golden Retriever" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Age</label>
              <input type="text" value="2 Years" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Sex</label>
              <input type="text" value="Female" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Color</label>
              <input type="text" value="Golden" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
          </div>

          <!-- User Details -->
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            Your Information
          </h3>
          <form>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="text-sm font-medium text-gray-600">Full Name</label>
                <input type="text"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your full name" required />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Email Address</label>
                <input type="email"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your email address" required />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Age</label>
                <input type="number"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your age" required />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Birthdate</label>
                <input type="date"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  required />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Contact Number</label>
                <input type="text"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your contact number" required />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Residential Address</label>
                <input type="text"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your address" required />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Civil Status</label>
                <select
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  required>
                  <option value="" disabled selected>
                    Select Civil Status
                  </option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Divorced">Divorced</option>
                </select>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Citizenship</label>
                <input type="text"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your citizenship" required />
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
              class="w-full mt-6 bg-orange-500 text-white font-medium rounded-lg py-3 hover:bg-yellow-500 transition duration-300">
              Submit Adoption Form
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF THE SECTION -->
</x-layout>