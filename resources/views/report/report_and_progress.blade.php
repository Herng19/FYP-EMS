<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

    {{-- Graph --}}
    <div class="mt-4 mx-12">
        <canvas id="myChart"></canvas>
    </div>

    {{-- Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
          const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
    </script>
</x-app-layout>