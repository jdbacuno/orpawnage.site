<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h1>

  <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Users (excluding admins) -->
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between h-32">
      <h2 class="text-lg font-semibold text-gray-700">Total Users</h2>
      <p class="text-3xl font-bold text-blue-600 text-right">{{ $totalUsers }}</p>
    </div>

    <!-- Total Pets -->
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between h-32">
      <h2 class="text-lg font-semibold text-gray-700">Total Pets</h2>
      <p class="text-3xl font-bold text-green-600 text-right">{{ $totalPets }}</p>
    </div>

    <!-- Total Adopted Pets -->
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between h-32">
      <h2 class="text-lg font-semibold text-gray-700">Adopted Pets</h2>
      <p class="text-3xl font-bold text-purple-600 text-right">{{ $totalAdoptedPets }}</p>
    </div>

    <!-- Total Incomplete Adoption Applications -->
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between h-32">
      <h2 class="text-lg font-semibold text-gray-700">Incomplete Adoptions</h2>
      <p class="text-3xl font-bold text-red-600 text-right">{{ $totalIncompleteAdoptionApplications }}</p>
    </div>
  </div>

  <!-- Chart Section -->
  <div class="bg-white shadow-md rounded-lg p-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Adoption Statistics</h2>
    <canvas id="adoptionChart"></canvas>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const ctx = document.getElementById("adoptionChart").getContext("2d");
      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Total Pets", "Adopted Pets", "Incomplete Adoptions"],
          datasets: [{
            label: "Count",
            data: [{{ $totalPets }}, {{ $totalAdoptedPets }}, {{ $totalIncompleteAdoptionApplications }}],
            backgroundColor: ["#10B981", "#8B5CF6", "#EF4444"],
          }],
        },
      });
    });
  </script>
</x-admin-layout>