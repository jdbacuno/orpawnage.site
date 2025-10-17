<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="relative custom-gradient sm:bg-none pb-0" id="mainContent">

    <!-- Mobile background image -->
    <div class="sm:hidden absolute inset-0 w-full h-full overflow-hidden z-0">
      <img src="{{ asset('images/adopter.jpg') }}" alt="Adopt a Pet" class="w-full h-full object-cover brightness-50" />
    </div>

    <!-- Desktop/Large screens: warm gradient + subtle pattern background -->
    <div class="hidden sm:block absolute inset-0 z-0">
      <div
        class="absolute inset-0 bg-gradient-to-br from-amber-50 via-orange-50 to-rose-100 animate-[gradientShift_14s_ease-in-out_infinite]">
      </div>
      <div class="absolute inset-0 opacity-40"
        style="background-image: radial-gradient(rgba(251, 191, 36, 0.25) 1px, transparent 1px); background-size: 22px 22px;">
      </div>
      <!-- Paw accents sprinkled like background (non-interactive) -->
      <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-30 text-7xl -top-10 left-8"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-6xl top-6 left-1/4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-5xl top-10 right-1/3"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-8xl top-1/3 -left-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-7xl top-1/2 left-1/5"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-20 text-6xl top-2/3 left-1/2"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-7xl bottom-10 right-16"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-20 text-5xl bottom-24 right-1/4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-6xl bottom-8 left-1/3"></i>
        <!-- Extra right-side sprinkles -->
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-6xl top-4 right-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-20 text-5xl top-1/4 right-10"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-7xl top-1/3 right-1/6"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-6xl top-1/2 right-3"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-7xl bottom-1/3 right-8"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-20 text-5xl bottom-1/5 right-1/12"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-6xl bottom-6 right-4"></i>
      </div>
    </div>

    <div class="relative z-10 max-w-screen-xl mx-auto py-4 px-4 md:px-8 lg:flex lg:items-center lg:gap-x-6">
      <!-- LEFT SIDE CONTENT -->
      <div class="lg:w-1/2 sm:mb-10 mb-0 text-left">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white sm:text-gray-900 leading-tight">
          <i class="ph-fill ph-paw-print text-yellow-500"></i> Browse pets
          at <span class="text-orange-500">OR<span class="text-yellow-500">PAW</span>NAGE</span>
          <br>Adopt. Don't shop.
        </h1>
        <p class="mt-4 text-white sm:text-gray-600">
          Browse through these pets looking for a new home. Give them
          a second chance at life.
        </p>

        <!-- Adoption Process Card -->
        <div
          class="my-6 relative p-6 bg-gray-50/80 backdrop-blur-lg rounded-lg border border-yellow-500 shadow-md overflow-hidden">
          <!-- Paw Accents -->
          <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-3xl -top-4 left-4"></i>
            <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-2xl top-8 right-8"></i>
            <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-15 text-3xl bottom-6 left-12"></i>
            <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-10 text-2xl bottom-2 right-6"></i>
            <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-xl top-20 left-20"></i>
            <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-10 text-2xl bottom-12 right-12"></i>
          </div>
          <div class="relative z-10">
            <h3 class="font-bold text-lg text-black mb-4">
              <i class="ph-fill ph-paw-print text-orange-500"></i> Adoption Process
            </h3>
          </div>

          <!-- Numbered Steps List -->
          <div class="mt-4 relative z-10 space-y-3 max-h-[500px] overflow-y-auto pr-2">
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
              <div class="flex items-start gap-3">
                <div
                  class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                  1
                </div>
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-800 mb-1">Submit Application</h4>
                  <p class="text-sm text-gray-600">Complete the adoption form below with accurate information. You can
                    only have one active application at a time.</p>
                </div>
              </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
              <div class="flex items-start gap-3">
                <div
                  class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                  2
                </div>
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-800 mb-1">Confirm Within 24 Hours</h4>
                  <p class="text-sm text-gray-600">You'll receive a confirmation email that <span
                      class="font-medium text-red-600">must be confirmed within 24 hours</span>. Failure to confirm will
                    automatically cancel your application.</p>
                </div>
              </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
              <div class="flex items-start gap-3">
                <div
                  class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                  3
                </div>
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-800 mb-1">Background Review</h4>
                  <p class="text-sm text-gray-600">Our team reviews confirmed applications. <span
                      class="font-medium text-orange-600">Priority is given to Angeles City residents.</span> If
                    multiple applicants are confirmed, we select based on background check and residency.</p>
                </div>
              </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
              <div class="flex items-start gap-3">
                <div
                  class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                  4
                </div>
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-800 mb-1">Schedule Visitation (48 Hours)</h4>
                  <p class="text-sm text-gray-600">If selected, you'll receive a scheduling email. You <span
                      class="font-medium text-red-600">must set a visitation date within 48 hours</span> (available
                    dates are within 7 business days). No response will cancel your application. Other applicants will
                    be notified that a candidate has been selected.</p>
                </div>
              </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
              <div class="flex items-start gap-3">
                <div
                  class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                  5
                </div>
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-800 mb-1">Visit & Verification</h4>
                  <p class="text-sm text-gray-600 mb-2">On your scheduled date, bring:</p>
                  <ul class="text-sm text-gray-600 list-disc list-inside ml-2 space-y-1">
                    <li>Valid government ID (matching the one you submitted)</li>
                    <li>Your transaction number</li>
                  </ul>
                  <p class="text-sm text-gray-600 mt-2">We'll discuss the pet's needs and care requirements. <span
                      class="font-medium text-green-600">Kittens/puppies 3 months or younger can usually go home
                      immediately</span> as they don't require taming yet.</p>
                </div>
              </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
              <div class="flex items-start gap-3">
                <div
                  class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                  6
                </div>
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-800 mb-1">Pickup & Photo</h4>
                  <p class="text-sm text-gray-600">Upon successful pickup, we'll take an official photo of you with your
                    new pet and adoption details. This will be featured on our Facebook page and website. If the pet has
                    health or behavioral issues, you may need to return for follow-up visits.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE IMAGE -->
      <div class="lg:w-1/2 relative">
        <div class="hidden sm:block w-full sm:max-w-[500px] mx-auto relative">
          <!-- Main Image -->
          <img src="{{ asset('images/adopter.jpg') }}" alt="Pet Adoption Hero Image"
            class="w-full rounded-xl brightness-[.75] relative z-10" />

          <!-- Paw Print Corner Accents -->
          <div class="absolute -top-12 -left-12 -rotate-45 text-yellow-500 z-20">
            <i class="ph-fill ph-paw-print text-8xl"></i>
          </div>
        </div>
      </div>
  </section>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START OF PET LISTING SECTION ========== -->
  <section class="bg-gray-50 py-8 sm:py-12 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">


      <!-- Livewire Component -->
      @livewire('pet-listing')
    </div>
  </section>
  <!-- ========== END OF PET LISTING SECTION ========== -->

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const header = document.getElementById('main-header');
      const mainContent = document.getElementById('mainContent');
      const adminIndicator = document.getElementById('adminIndicator');

      const EXTRA_TOP_SPACING_PX = 8;

      function computeHeights() {
        const headerHeight = header ? header.offsetHeight : 0;
        const adminHeight = adminIndicator ? adminIndicator.offsetHeight : 0;
        return { headerHeight, adminHeight };
      }

      function updateHeaderSpacer() {
        if (!mainContent) return;
        const { headerHeight, adminHeight } = computeHeights();
        const totalTop = headerHeight + adminHeight;

        if (adminIndicator) {
          mainContent.style.paddingTop = `${(totalTop + EXTRA_TOP_SPACING_PX) * .7}px`;
        } else {
          mainContent.style.paddingTop = `${(totalTop + EXTRA_TOP_SPACING_PX)}px`;
        }
      }

      updateHeaderSpacer();
      window.addEventListener('resize', updateHeaderSpacer);

      if (window.ResizeObserver) {
        const ro = new ResizeObserver(updateHeaderSpacer);
        if (header) ro.observe(header);
        if (adminIndicator) ro.observe(adminIndicator);
      }
    });
  </script>

  @livewireScripts
</x-layout>
