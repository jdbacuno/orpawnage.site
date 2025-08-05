<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h1>

  <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users (excluding admins) -->
    <div
      class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between h-32 cursor-pointer hover:shadow-lg transition-shadow duration-300"
      onclick="window.location.href='{{ route('admin.users') }}'">
      <h2 class="text-lg font-semibold text-gray-700">Total Users</h2>
      <p class="text-3xl font-bold text-blue-600 text-right">{{ $totalUsers }}</p>
      <div class="text-xs text-gray-500 text-right">Click to view all users</div>
    </div>

    <!-- Total Available Pets -->
    <div
      class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between h-32 cursor-pointer hover:shadow-lg transition-shadow duration-300"
      onclick="window.location.href='{{ route('admin.pet-profiles') }}'">
      <h2 class="text-lg font-semibold text-gray-700">Available Pets</h2>
      <p class="text-3xl font-bold text-green-600 text-right">{{ $totalAvailablePets }}</p>
      <div class="text-xs text-gray-500 text-right">Click to manage pets</div>
    </div>

    <!-- Current Month Adopted Pets -->
    <div
      class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between h-32 cursor-pointer hover:shadow-lg transition-shadow duration-300"
      onclick="showAdoptionRateModal()">
      <h2 class="text-lg font-semibold text-gray-700">This Month Adoptions</h2>
      <p class="text-3xl font-bold text-purple-600 text-right">{{ $currentMonthAdoptions }}</p>
      <div class="text-xs text-gray-500 text-right">Click to view rates</div>
    </div>

    <!-- Total Incomplete Adoption Applications -->
    <div
      class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between h-32 cursor-pointer hover:shadow-lg transition-shadow duration-300"
      onclick="window.location.href='{{ route('admin.adoption-applications') }}?status=to+be+picked+up&status=to+be+scheduled'">
      <h2 class="text-lg font-semibold text-gray-700">Incomplete Adoptions</h2>
      <p class="text-3xl font-bold text-red-600 text-right">{{ $totalIncompleteAdoptionApplications }}</p>
      <div class="text-xs text-gray-500 text-right">Click to view list</div>
    </div>
  </div>

  <!-- Additional Statistics -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Pets Overview -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">Pet Statistics</h3>
      <div class="space-y-3">
        <div class="flex justify-between">
          <span class="text-gray-600">Total Pets:</span>
          <span class="font-semibold">{{ $totalPets }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Archived Pets:</span>
          <span class="font-semibold text-gray-500">{{ $totalArchivedPets }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Total Adopted (All Time):</span>
          <span class="font-semibold text-purple-600">{{ $totalAdoptedPets }}</span>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Activity (7 Days)</h3>
      <div class="space-y-3">
        <div class="flex justify-between">
          <span class="text-gray-600">New Adoptions:</span>
          <span class="font-semibold text-green-600">{{ $recentAdoptions }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">New Applications:</span>
          <span class="font-semibold text-blue-600">{{ $recentApplications }}</span>
        </div>
      </div>
    </div>

    <!-- Monthly Comparison -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">Monthly Comparison</h3>
      <div class="space-y-3">
        <div class="flex justify-between">
          <span class="text-gray-600">This Month:</span>
          <span class="font-semibold text-purple-600">{{ $currentMonthAdoptions }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Last Month:</span>
          <span class="font-semibold text-gray-600">{{ $previousMonthAdoptions }}</span>
        </div>
        @php
        $change = $currentMonthAdoptions - $previousMonthAdoptions;
        $changePercent = $previousMonthAdoptions > 0 ? round(($change / $previousMonthAdoptions) * 100, 1) : 0;
        @endphp
        <div class="flex justify-between">
          <span class="text-gray-600">Change:</span>
          <span class="font-semibold {{ $change >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $change >= 0 ? '+' : '' }}{{ $change }} ({{ $changePercent }}%)
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart Section -->
  <div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold text-gray-700">Daily Adoption Statistics</h2>
      <div class="flex gap-2">
        <select id="chartMonth"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg pl-2 py-2 pr-8">
          @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ $i==now()->month ? 'selected' : '' }}>
            {{ Carbon\Carbon::create()->month($i)->format('F') }}
            </option>
            @endfor
        </select>
        <select id="chartYear"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg pl-2 py-2 pr-6">
          @for($year = 2024; $year <= now()->year; $year++)
            <option value="{{ $year }}" {{ $year==now()->year ? 'selected' : '' }}>
              {{ $year }}
            </option>
            @endfor
        </select>
        <button onclick="updateChart()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
          Update
        </button>
      </div>
    </div>
    <canvas id="adoptionChart"></canvas>
  </div>

  <!-- Monthly Trend Chart Section -->
  <div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold text-gray-700">Monthly Adoption Trends</h2>
      <div class="flex gap-2 items-center">
        <div class="flex items-center gap-2">
          <label class="text-sm text-gray-600">From:</label>
          <input type="month" id="startDate" value="{{ now()->subMonths(11)->format('Y-m') }}" 
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg px-3 py-2"
            max="{{ now()->format('Y-m') }}">
        </div>
        <div class="flex items-center gap-2">
          <label class="text-sm text-gray-600">To:</label>
          <input type="month" id="endDate" value="{{ now()->format('Y-m') }}" 
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg px-3 py-2"
            max="{{ now()->format('Y-m') }}">
        </div>
        <button onclick="updateTrendChart()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
          Update
        </button>
      </div>
    </div>
    <canvas id="monthlyTrendChart"></canvas>
  </div>

  <!-- Adoption Rate Modal -->
  <div id="adoptionRateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
        <div class="flex justify-between items-center p-6 border-b">
          <h3 class="text-xl font-semibold text-gray-900">Adoption Rate History</h3>
          <button onclick="closeAdoptionRateModal()" class="text-gray-400 hover:text-gray-600">
            <i class="ph-fill ph-x text-2xl"></i>
          </button>
        </div>
        <div class="p-6">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Select Period:</label>
            <div class="flex gap-2">
              <select id="rateMonth"
                class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg pl-2 py-2 pr-8">
                @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ $i==now()->month ? 'selected' : '' }}>
                  {{ Carbon\Carbon::create()->month($i)->format('F') }}
                  </option>
                  @endfor
              </select>
              <select id="rateYear"
                class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg pl-2 py-2 pr-6">
                @for($year = 2024; $year <= now()->year; $year++)
                  <option value="{{ $year }}" {{ $year==now()->year ? 'selected' : '' }}>
                    {{ $year }}
                  </option>
                  @endfor
              </select>
              <button onclick="loadAdoptionRate()"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Load
              </button>
            </div>
          </div>
          <div id="adoptionRateContent" class="space-y-4">
            <!-- Content will be loaded here -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    let adoptionChart;
    let monthlyTrendChart;

    document.addEventListener("DOMContentLoaded", function () {
      initializeChart();
      initializeTrendChart();
    });

    function initializeChart() {
      const ctx = document.getElementById("adoptionChart").getContext("2d");
      const chartData = @json($currentMonthData);
      
      adoptionChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: chartData.map(item => item.date),
          datasets: [
            {
              label: "Canine",
              data: chartData.map(item => item.canine),
              backgroundColor: "#3B82F6",
              borderColor: "#2563EB",
              borderWidth: 1
            },
            {
              label: "Feline",
              data: chartData.map(item => item.feline),
              backgroundColor: "#F59E0B",
              borderColor: "#D97706",
              borderWidth: 1
            }
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: true,
              position: 'top'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1
              }
            }
          }
        }
      });
    }

    function initializeTrendChart() {
      const ctx = document.getElementById("monthlyTrendChart").getContext("2d");
      const chartData = @json($monthlyTrendData);
      
      monthlyTrendChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: chartData.map(item => item.month),
          datasets: [
            {
              label: "Canine",
              data: chartData.map(item => item.canine),
              backgroundColor: "#3B82F6",
              borderColor: "#2563EB",
              borderWidth: 1
            },
            {
              label: "Feline",
              data: chartData.map(item => item.feline),
              backgroundColor: "#F59E0B",
              borderColor: "#D97706",
              borderWidth: 1
            }
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: true,
              position: 'top'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1
              }
            }
          }
        }
      });
    }

    function updateChart() {
      const month = document.getElementById('chartMonth').value;
      const year = document.getElementById('chartYear').value;
      
      fetch(`/admin/adoption-stats?month=${month}&year=${year}`)
        .then(response => response.json())
        .then(data => {
          adoptionChart.data.labels = data.map(item => item.date);
          adoptionChart.data.datasets[0].data = data.map(item => item.canine);
          adoptionChart.data.datasets[1].data = data.map(item => item.feline);
          adoptionChart.update();
        })
        .catch(error => console.error('Error:', error));
    }

    function updateTrendChart() {
      const startDate = document.getElementById('startDate').value;
      const endDate = document.getElementById('endDate').value;
      const currentDate = new Date().toISOString().slice(0, 7); // YYYY-MM format
      
      // Validate date range
      if (startDate > endDate) {
        alert('Start date cannot be after end date');
        return;
      }
      
      if (endDate > currentDate) {
        alert('End date cannot exceed current date');
        return;
      }
      
      // Validate range limit (maximum 2 years)
      const start = new Date(startDate + '-01');
      const end = new Date(endDate + '-01');
      const monthsDifference = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth()) + 1;
      
      if (monthsDifference > 24) {
        alert('Date range cannot exceed 2 years (24 months)');
        return;
      }
      
      fetch(`/admin/monthly-trend-stats?startDate=${startDate}&endDate=${endDate}`)
        .then(response => {
          if (!response.ok) {
            return response.json().then(data => {
              throw new Error(data.error || 'Failed to fetch data');
            });
          }
          return response.json();
        })
        .then(data => {
          monthlyTrendChart.data.labels = data.map(item => item.month);
          monthlyTrendChart.data.datasets[0].data = data.map(item => item.canine);
          monthlyTrendChart.data.datasets[1].data = data.map(item => item.feline);
          monthlyTrendChart.update();
        })
        .catch(error => {
          console.error('Error:', error);
          alert(error.message);
        });
    }

    function showAdoptionRateModal() {
      document.getElementById('adoptionRateModal').classList.remove('hidden');
      loadAdoptionRate();
    }

    function closeAdoptionRateModal() {
      document.getElementById('adoptionRateModal').classList.add('hidden');
    }

    function loadAdoptionRate() {
      const month = document.getElementById('rateMonth').value;
      const year = document.getElementById('rateYear').value;
      const monthName = new Date(year, month - 1).toLocaleString('default', { month: 'long' });
      
      fetch(`/admin/adoption-stats?month=${month}&year=${year}`)
        .then(response => response.json())
        .then(data => {
          const totalCanine = data.reduce((sum, item) => sum + item.canine, 0);
          const totalFeline = data.reduce((sum, item) => sum + item.feline, 0);
          const totalAdoptions = totalCanine + totalFeline;
          
          document.getElementById('adoptionRateContent').innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="bg-blue-50 p-4 rounded-lg">
                <h4 class="font-semibold text-blue-800">Total Adoptions</h4>
                <p class="text-2xl font-bold text-blue-600">${totalAdoptions}</p>
                <p class="text-sm text-blue-600">${monthName} ${year}</p>
              </div>
              <div class="bg-blue-50 p-4 rounded-lg">
                <h4 class="font-semibold text-blue-800">Canine</h4>
                <p class="text-2xl font-bold text-blue-600">${totalCanine}</p>
                <p class="text-sm text-blue-600">${monthName} ${year}</p>
              </div>
              <div class="bg-orange-50 p-4 rounded-lg">
                <h4 class="font-semibold text-orange-800">Feline</h4>
                <p class="text-2xl font-bold text-orange-600">${totalFeline}</p>
                <p class="text-sm text-orange-600">${monthName} ${year}</p>
              </div>
            </div>
            <div class="mt-4">
              <h4 class="font-semibold text-gray-700 mb-2">Daily Breakdown:</h4>
              <div class="max-h-60 overflow-y-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                  ${data.map(item => `
                    <div class="bg-gray-50 p-2 rounded text-center">
                      <div class="text-sm font-medium">${item.date}</div>
                      <div class="text-lg font-bold ${item.canine > 0 ? 'text-blue-600' : 'text-gray-400'}">C: ${item.canine}</div>
                      <div class="text-lg font-bold ${item.feline > 0 ? 'text-orange-600' : 'text-gray-400'}">F: ${item.feline}</div>
                    </div>
                  `).join('')}
                </div>
              </div>
            </div>
          `;
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById('adoptionRateContent').innerHTML = '<p class="text-red-600">Error loading data</p>';
        });
    }

    // Close modal when clicking outside
    document.getElementById('adoptionRateModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeAdoptionRateModal();
      }
    });
  </script>
</x-admin-layout>