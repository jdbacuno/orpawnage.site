<x-layout>
  <div id="mainContent">
    <!-- ========== WHO WE ARE SECTION ========== -->
    <section class="relative bg-gray-20 pt-16 pb-4">

      <!-- Desktop/Large screens: warm gradient + subtle pattern background -->
      <div class="hidden sm:block absolute inset-0 z-0">
        <div
          class="absolute inset-0 bg-gradient-to-br from-amber-50 via-orange-50 to-rose-100 animate-[gradientShift_14s_ease-in-out_infinite]">
        </div>
        <div class="absolute inset-0 opacity-40"
          style="background-image: radial-gradient(rgba(251, 191, 36, 0.25) 1px, transparent 1px); background-size: cover;">
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
      <div class="relative z-10 max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
          <!-- Image -->
          <div class="relative rounded-xl overflow-hidden">
            <img src="{{ asset('images/orpawnage-logo.png') }}" alt="Orpawnage logo"
              class="w-full h-auto object-cover transition-transform duration-300 hover:scale-105" />
            <div class="absolute -bottom-1 -left-1 w-24 h-24 border-l-4 border-b-4 border-orange-500"></div>
            <div class="absolute -top-1 -right-1 w-24 h-24 border-t-4 border-r-4 border-yellow-400"></div>
          </div>

          <!-- Content -->
          <div>
            <div class="inline-block px-4 py-2 bg-orange-100 rounded-full mb-4">
              <span class="text-orange-600 font-medium flex items-center">
                <i class="ph-fill ph-paw-print mr-2"></i> Our Purpose
              </span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
              About <span class="text-yellow-500">OR<span class="text-orange-500">PAW</span>NAGE</span> </h2>
            <div class="space-y-4 text-gray-600 text-lg">
              <p>
                OrPAWnage serves as the digital platform for pet lovers or potential adopters looking to welcome a new
                furry family member. Our office operates under the city government's commitment to
                responsible pet ownership and community health.
              </p>
              <p>
                Through this website, we provide streamlined access to veterinary services, pet adoption programs,
                and animal control resources. Our physical office handles licensing, vaccinations, and animal
                rescue operations throughout Angeles City.
              </p>
              <p>
                The Veterinary Office staff consists of licensed veterinarians, animal control officers, and
                support personnel dedicated to maintaining animal welfare standards and public health safety
                throughout our community.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ========== MISSION & VALUES SECTION ========== -->
    <section class="py-16 bg-gray-100/90">
      <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Our Mission & Values
          </h2>
          <div class="w-24 h-1 bg-black mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Mission Card -->
          <div
            class="text-center md:text-left bg-gray-50 rounded-xl p-8 border border-gray-200 hover:border-orange-300 transition-all duration-300">
            <div class="mx-auto w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
              <i class="ph-fill ph-heart text-orange-500 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Our Mission</h3>
            <p class="text-gray-600">
              To rescue, rehabilitate, and rehome abandoned and abused animals while promoting responsible
              pet ownership through community education and outreach programs.
            </p>
          </div>

          <!-- Vision Card -->
          <div
            class="text-center md:text-left bg-gray-50 rounded-xl p-8 border border-gray-200 hover:border-orange-300 transition-all duration-300">
            <div class="mx-auto w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
              <i class="ph-fill ph-eye text-orange-500 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Our Vision</h3>
            <p class="text-gray-600">
              A world where every pet is valued, every owner is responsible, and no animal suffers from
              neglect or abandonment.
            </p>
          </div>

          <!-- Values Card -->
          <div
            class="text-center md:text-left bg-gray-50 rounded-xl p-8 border border-gray-200 hover:border-orange-300 transition-all duration-300">
            <div class="mx-auto w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
              <i class="ph-fill ph-shield-star text-orange-500 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Our Values</h3>
            <ul class="text-left space-y-2 text-gray-600">
              <li class="flex items-start">
                <i class="ph-fill ph-check-circle text-yellow-400 mr-2 mt-1"></i>
                <span>Compassion for all living creatures</span>
              </li>
              <li class="flex items-start">
                <i class="ph-fill ph-check-circle text-yellow-400 mr-2 mt-1"></i>
                <span>Integrity in all our actions</span>
              </li>
              <li class="flex items-start">
                <i class="ph-fill ph-check-circle text-yellow-400 mr-2 mt-1"></i>
                <span>Commitment to excellence in animal care</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- ========== SERVICES SECTION ========== -->
    <section class="py-16 bg-yellow-20 relative overflow-hidden">
      <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="w-full h-full bg-center bg-cover" style="background-image: url('{{ asset('images/pets.png') }}');">
        </div>
        {{-- <div class="absolute inset-0 bg-white/60"></div> --}}
      </div>
      <div class="relative z-10 max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Our Animal Care Services
          </h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Comprehensive support for pets, wildlife, and their caregivers
          </p>
          <div class="w-24 h-1 bg-black mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Left Column -->
          <div class="space-y-8">
            <!-- Adoption Services -->
            <div
              class="bg-white/70 backdrop-blur-sm rounded-xl p-8 shadow-sm border border-gray-200 hover:border-orange-300 transition-all duration-300">
              <div class="flex flex-col gap-y-4 sm:flex-row items-start">
                <div class="flex-shrink-0 mx-auto sm:mr-6">
                  <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="ph-fill ph-heart text-orange-500 text-xl"></i>
                  </div>
                </div>
                <div class="text-center sm:text-left">
                  <h3 class="text-xl font-bold text-gray-900 mb-2">Pet Adoption</h3>
                  <p class="text-gray-600">
                    Find your perfect companion through our careful matching process. We help homeless pets find loving
                    forever families with thorough screening and post-adoption support.
                  </p>
                </div>
              </div>
            </div>

            <!-- Surrender Services -->
            <div
              class="bg-white/70 backdrop-blur-sm rounded-xl p-8 shadow-sm border border-gray-200 hover:border-orange-300 transition-all duration-300">
              <div class="flex flex-col gap-y-4 sm:flex-row items-start">
                <div class="flex-shrink-0 mx-auto sm:mr-6">
                  <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="ph-fill ph-hand-heart text-orange-500 text-xl"></i>
                  </div>
                </div>
                <div class="text-center sm:text-left">
                  <h3 class="text-xl font-bold text-gray-900 mb-2">Pet Surrender</h3>
                  <p class="text-gray-600">
                    Compassionate assistance for owners who can no longer care for their pets. We provide safe shelter
                    and
                    rehoming services with no judgment.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column -->
          <div class="space-y-8">
            <!-- Wildlife Services -->
            <div
              class="bg-white/70 backdrop-blur-sm rounded-xl p-8 shadow-sm border border-gray-200 hover:border-orange-300 transition-all duration-300">
              <div class="flex flex-col gap-y-4 sm:flex-row items-start">
                <div class="flex-shrink-0 mx-auto sm:mr-6">
                  <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="ph-fill ph-tree text-orange-500 text-xl"></i>
                  </div>
                </div>
                <div class="text-center sm:text-left">
                  <h3 class="text-xl font-bold text-gray-900 mb-2">Wildlife Assistance</h3>
                  <p class="text-gray-600">
                    Help for found or injured wild animals. Our trained staff can assess, provide temporary care, and
                    coordinate with wildlife rehabilitators when needed.
                  </p>
                </div>
              </div>
            </div>

            <!-- Reporting Services -->
            <div
              class="bg-white/70 backdrop-blur-sm rounded-xl p-8 shadow-sm border border-gray-200 hover:border-orange-300 transition-all duration-300">
              <div class="flex flex-col gap-y-4 sm:flex-row items-start">
                <div class="flex-shrink-0 mx-auto sm:mr-6">
                  <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="ph-fill ph-megaphone text-orange-500 text-xl"></i>
                  </div>
                </div>
                <div class="text-center sm:text-left">
                  <h3 class="text-xl font-bold text-gray-900 mb-2">Animal Reporting</h3>
                  <p class="text-gray-600">
                    Report missing pets, stray animals, or cases of suspected abuse. Our team responds promptly to all
                    reports and works with local authorities when needed.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Additional Row for Medical Services -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Medical Services -->
          <div
            class="bg-white/70 backdrop-blur-sm rounded-xl p-8 shadow-sm border border-gray-200 hover:border-orange-300 transition-all duration-300">
            <div class="flex flex-col gap-y-4 sm:flex-row items-start">
              <div class="flex-shrink-0 mx-auto sm:mr-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                  <i class="ph-fill ph-stethoscope text-orange-500 text-xl"></i>
                </div>
              </div>
              <div class="text-center sm:text-left">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Free Medical Services</h3>
                <p class="text-gray-600">
                  Accessible veterinary care including spay/neuter procedures, checkup, and vaccination drives held in
                  barangays to ensure the well-being of stray and owned animals.
                </p>
              </div>
            </div>
          </div>

          <!-- Emergency Services -->
          <div
            class="bg-white/70 backdrop-blur-sm rounded-xl p-8 shadow-sm border border-gray-200 hover:border-orange-300 transition-all duration-300">
            <div class="flex flex-col gap-y-4 sm:flex-row items-start">
              <div class="flex-shrink-0 mx-auto sm:mr-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                  <i class="ph-fill ph-ambulance text-orange-500 text-xl"></i>
                </div>
              </div>
              <div class="text-center sm:text-left">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Emergency Care</h3>
                <p class="text-gray-600">
                  Immediate medical attention for injured or severely ill stray animals. We stabilize critical cases and
                  provide necessary treatment.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ========== TEAM SECTION ========== -->
    @if($staff->count() > 0)
    <section class="py-16 md:py-24 bg-gray-500 text-white">
      <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold mb-4">
            Meet Our Team
          </h2>
          <p class="text-orange-100 max-w-2xl mx-auto">
            Passionate professionals dedicated to animal welfare
          </p>
          <div class="w-24 h-1 bg-yellow-400 mx-auto mt-4"></div>
        </div>

        <!-- Team Grid Container -->
        <div id="teamContainer">
          <!-- First 4 team members on mobile, 5 on desktop (always visible) -->
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 mb-6 sm:mb-8">
            @foreach($staff->sortBy('order')->take(4) as $member)
            <div class="group text-center">
              <div
                class="relative mb-3 sm:mb-4 overflow-hidden rounded-full w-20 h-20 sm:w-32 sm:h-32 mx-auto shadow-lg">
                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}"
                  class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                <div
                  class="absolute inset-0 bg-orange-700/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
              </div>
              <h3 class="font-bold text-sm sm:text-md">{{ ucwords(strtolower($member->name)) }}</h3>
              <p class="text-orange-100 text-xs sm:text-sm">{{ ucwords($member->position) }}</p>
            </div>
            @endforeach

            <!-- 5th member visible only on larger screens -->
            @if($staff->count() >= 5)
            <div class="hidden lg:block group text-center">
              @php $fifthMember = $staff->sortBy('order')->skip(4)->first(); @endphp
              <div
                class="relative mb-3 sm:mb-4 overflow-hidden rounded-full w-20 h-20 sm:w-32 sm:h-32 mx-auto shadow-lg">
                <img src="{{ asset('storage/' . $fifthMember->image_path) }}" alt="{{ $fifthMember->name }}"
                  class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                <div
                  class="absolute inset-0 bg-orange-700/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
              </div>
              <h3 class="font-bold text-sm sm:text-lg">{{ ucwords(strtolower($fifthMember->name)) }}</h3>
              <p class="text-orange-100 text-xs sm:text-sm">{{ ucwords($fifthMember->position) }}</p>
            </div>
            @endif
          </div>

          @if($staff->count() > 4)
          <!-- Additional team members (initially hidden) -->
          <div id="additionalTeamMembers" class="hidden">
            <!-- Mobile: Skip first 4, Desktop: Skip first 5 -->
            <div class="lg:hidden">
              @php
              $mobileAdditionalStaff = $staff->sortBy('order')->skip(4);
              $mobileChunks = $mobileAdditionalStaff->chunk(4);
              @endphp

              @foreach($mobileChunks as $chunkIndex => $chunk)
              <div
                class="mx-auto grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 opacity-0 transform translate-y-8 transition-all duration-700"
                style="transition-delay: {{ $chunkIndex * 0.1 }}s;">
                @foreach($chunk as $member)
                <div class="group text-center">
                  <div
                    class="relative mb-3 sm:mb-4 overflow-hidden rounded-full w-20 h-20 sm:w-32 sm:h-32 mx-auto shadow-lg">
                    <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}"
                      class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    <div
                      class="absolute inset-0 bg-orange-700/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                  </div>
                  <h3 class="font-bold text-sm sm:text-md">{{ ucwords(strtolower($member->name)) }}</h3>
                  <p class="text-orange-100 text-xs sm:text-sm">{{ ucwords($member->position) }}</p>
                </div>
                @endforeach
              </div>
              @endforeach
            </div>

            <div class="hidden lg:block">
              @php
              $desktopAdditionalStaff = $staff->sortBy('order')->skip(5);
              $desktopChunks = $desktopAdditionalStaff->chunk(5);
              @endphp

              @foreach($desktopChunks as $chunkIndex => $chunk)
              <div
                class="mx-auto grid grid-cols-5 gap-4 sm:gap-6 mb-6 sm:mb-8 opacity-0 transform translate-y-8 transition-all duration-700"
                style="transition-delay: {{ $chunkIndex * 0.1 }}s;">
                @foreach($chunk as $member)
                <div class="group text-center">
                  <div
                    class="relative mb-3 sm:mb-4 overflow-hidden rounded-full w-20 h-20 sm:w-32 sm:h-32 mx-auto shadow-lg">
                    <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}"
                      class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    <div
                      class="absolute inset-0 bg-orange-700/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                  </div>
                  <h3 class="font-bold text-sm sm:text-lg">{{ ucwords(strtolower($member->name)) }}</h3>
                  <p class="text-orange-100 text-xs sm:text-sm">{{ ucwords($member->position) }}</p>
                </div>
                @endforeach
              </div>
              @endforeach
            </div>
          </div>

          <!-- See More/See Less Button -->
          <div class="text-center mt-8 sm:mt-12">
            <button id="toggleTeamBtn"
              class="group relative px-6 py-3 sm:px-8 sm:py-4 bg-orange-500 hover:bg-yellow-400 text-white hover:text-gray-900 font-bold rounded-full shadow-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
              <span class="flex items-center justify-center">
                <i id="toggleIcon"
                  class="ph-fill ph-arrow-down mr-2 text-lg sm:text-xl transition-transform duration-300"></i>
                <span id="toggleText" class="text-sm sm:text-base">See More Team Members</span>
              </span>
              <div
                class="absolute inset-0 bg-white/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              </div>
            </button>

            <!-- Team count indicator -->
            <p class="text-orange-100 text-sm mt-4">
              <span id="visibleCount" class="lg:hidden">4</span><span id="visibleCountDesktop"
                class="hidden lg:inline">5</span> of <span id="totalCount">{{ $staff->count() }}</span> team members
              shown
            </p>
          </div>
          @endif
        </div>
      </div>

      @if($staff->count() > 4)
      <script>
        document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('toggleTeamBtn');
      const toggleIcon = document.getElementById('toggleIcon');
      const toggleText = document.getElementById('toggleText');
      const additionalMembers = document.getElementById('additionalTeamMembers');
      const visibleCount = document.getElementById('visibleCount');
      const visibleCountDesktop = document.getElementById('visibleCountDesktop');
      const totalCount = document.getElementById('totalCount');

      let isExpanded = false;
      const totalMembers = {{ $staff->count() }};

      toggleBtn.addEventListener('click', function() {
        if (!isExpanded) {
          // Expand
          additionalMembers.classList.remove('hidden');

          // Animate each row with staggered delay
          const rows = additionalMembers.querySelectorAll('.grid');
          rows.forEach((row, index) => {
            setTimeout(() => {
              row.classList.remove('opacity-0', 'translate-y-8');
              row.classList.add('opacity-100', 'translate-y-0');
            }, index * 150);
          });

          // Update button
          setTimeout(() => {
            toggleIcon.className = 'ph-fill ph-arrow-up mr-2 text-xl transition-transform duration-300 rotate-180';
            toggleText.textContent = 'See Less';
            visibleCount.textContent = totalMembers;
            visibleCountDesktop.textContent = totalMembers;
            isExpanded = true;
          }, 300);

          // Smooth scroll to keep button in view
          setTimeout(() => {
            toggleBtn.scrollIntoView({
              behavior: 'smooth',
              block: 'center'
            });
          }, 600);

        } else {
          // Collapse
          const rows = additionalMembers.querySelectorAll('.grid');

          // Animate out with reverse staggered delay
          rows.forEach((row, index) => {
            setTimeout(() => {
              row.classList.add('opacity-0', 'translate-y-8');
              row.classList.remove('opacity-100', 'translate-y-0');
            }, (rows.length - 1 - index) * 100);
          });

          // Hide after animation
          setTimeout(() => {
            additionalMembers.classList.add('hidden');
            toggleIcon.className = 'ph-fill ph-arrow-down mr-2 text-xl transition-transform duration-300';
            toggleText.textContent = 'See More Team Members';
            visibleCount.textContent = '4';
            visibleCountDesktop.textContent = '5';
            isExpanded = false;
          }, 500);
        }
      });
    });
      </script>
      @endif
    </section>
    @endif

    <!-- ========== CTA SECTION ========== -->
    <section class="py-16 md:py-24 bg-gray-900 text-white">
      <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
          Ready to Make a Difference?
        </h2>
        <p class="text-gray-300 max-w-2xl mx-auto mb-8">
          Whether you want to adopt, volunteer, or support our mission, we'd love to have you join
          the OrPAWnage family.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a href="/services/adopt-a-pet"
            class="px-6 py-3 bg-orange-500 hover:bg-yellow-400 hover:text-black rounded-md font-medium transition-colors duration-200 flex items-center justify-center">
            <i class="ph-fill ph-paw-print mr-2"></i> Adopt a Pet
          </a>
          <a href="/donate"
            class="px-6 py-3 bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 rounded-md font-medium transition-colors duration-200 flex items-center justify-center">
            <i class="ph-fill ph-hand-heart mr-2"></i> Donate Now
          </a>
        </div>
      </div>
    </section>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const header = document.getElementById('main-header');
        const mainContent = document.getElementById('mainContent');
        const adminIndicator = document.getElementById('adminIndicator');

        const EXTRA_TOP_SPACING_PX = 0;

        function computeHeights() {
          const headerHeight = header ? header.offsetHeight : 0;
          const adminHeight = adminIndicator ? adminIndicator.offsetHeight : 0;
          return { headerHeight, adminHeight };
        }

        function updateHeaderSpacer() {
          if (!mainContent) return;
          const { headerHeight, adminHeight } = computeHeights();
          const isMobile = window.innerWidth < 768;
          let totalTop = (adminHeight || 0) + (isMobile ? (headerHeight || 0) : 0);
          if (isMobile) {
            const SECTION_TOP_PADDING_SM_PX = 80; // tighter gap on mobile
            totalTop = Math.max(0, totalTop - SECTION_TOP_PADDING_SM_PX);
          }

          if (adminIndicator) {
            mainContent.style.paddingTop = '0px';
            mainContent.style.marginTop = `${((totalTop || 0) + EXTRA_TOP_SPACING_PX) * .7}px`;
          } else {
            mainContent.style.paddingTop = '0px';
            mainContent.style.marginTop = `${(totalTop || 0) + EXTRA_TOP_SPACING_PX}px`;
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
  </div>
</x-layout>
