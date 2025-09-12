<x-layout>
  <!-- ========== WHO WE ARE SECTION ========== -->
  <section class="bg-gray-20 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Image -->
        <div class="order-2 lg:order-1 relative rounded-xl overflow-hidden">
          <img src="{{ asset('images/orpawnage-logo.png') }}" alt="Orpawnage logo"
            class="w-full h-auto object-cover transition-transform duration-300 hover:scale-105" />
          <div class="absolute -bottom-1 -left-1 w-24 h-24 border-l-4 border-b-4 border-orange-500"></div>
          <div class="absolute -top-1 -right-1 w-24 h-24 border-t-4 border-r-4 border-yellow-400"></div>
        </div>

        <!-- Content -->
        <div class="order-1 lg:order-2">
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
          class="bg-gray-50 rounded-xl p-8 border border-gray-200 hover:border-orange-300 transition-all duration-300">
          <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
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
          class="bg-gray-50 rounded-xl p-8 border border-gray-200 hover:border-orange-300 transition-all duration-300">
          <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
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
          class="bg-gray-50 rounded-xl p-8 border border-gray-200 hover:border-orange-300 transition-all duration-300">
          <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
            <i class="ph-fill ph-shield-star text-orange-500 text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Our Values</h3>
          <ul class="space-y-2 text-gray-600">
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
              <div class="flex-shrink-0 mr-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                  <i class="ph-fill ph-heart text-orange-500 text-xl"></i>
                </div>
              </div>
              <div>
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
              <div class="flex-shrink-0 mr-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                  <i class="ph-fill ph-hand-heart text-orange-500 text-xl"></i>
                </div>
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pet Surrender</h3>
                <p class="text-gray-600">
                  Compassionate assistance for owners who can no longer care for their pets. We provide safe shelter and
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
              <div class="flex-shrink-0 mr-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                  <i class="ph-fill ph-tree text-orange-500 text-xl"></i>
                </div>
              </div>
              <div>
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
              <div class="flex-shrink-0 mr-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                  <i class="ph-fill ph-megaphone text-orange-500 text-xl"></i>
                </div>
              </div>
              <div>
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
            <div class="flex-shrink-0 mr-6">
              <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="ph-fill ph-stethoscope text-orange-500 text-xl"></i>
              </div>
            </div>
            <div>
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
            <div class="flex-shrink-0 mr-6">
              <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="ph-fill ph-ambulance text-orange-500 text-xl"></i>
              </div>
            </div>
            <div>
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

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
        @foreach($staff->sortBy('order')->take(5) as $member)
        <div class="group text-center">
          <div class="relative mb-4 overflow-hidden rounded-full w-32 h-32 mx-auto shadow-lg">
            <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
            <div
              class="absolute inset-0 bg-orange-700/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
          </div>
          <h3 class="font-bold text-lg">{{ ucwords(strtolower($member->name)) }}</h3>
          <p class="text-orange-100 text-sm">{{ ucwords($member->position) }}</p>
        </div>
        @endforeach
      </div>
    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
      function updateHeaderSpacer() {
          const header = document.getElementById('main-header');
          const mainContent = document.getElementById('mainContent');
          
          if (header && mainContent) {
              const headerHeight = header.offsetHeight;
              mainContent.style.marginTop = `${headerHeight}px`;
          }
      }

      // Initial update
      updateHeaderSpacer();

      // Update on window resize
      window.addEventListener('resize', updateHeaderSpacer);
    });
  </script>
</x-layout>