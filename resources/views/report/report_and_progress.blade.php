<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

    {{-- Graph --}}
    <div class="mt-4 mx-12">
        <canvas id="myChart" class="rounded-lg shadow p-8"></canvas>
    </div>

    {{-- Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      $(document).ready(function() {
        var sampleChartClass;
        const ctx = document.getElementById('myChart');
        var labels = Object.keys(@json($data));
        var values = Object.values(@json($data));

        // Graph Settings
        sampleChartClass = {
          ChartData:function(ctx, type, labels, data){
            new Chart(ctx, {
              type: type,
              data: {
                labels: labels,
                datasets: [{
                  label: 'Student Marks',
                  data: values,
                  borderWidth: 1, 
                  borderRadius: 20,
                  backgroundColor: [
                    'rgba(0, 170, 160, 0.8)',
                  ],
                  width: 10, 
                }]
              },
              options: {
                plugins: {
                  title: {
                    display: true,
                    text: 'Supervisee Marks',
                    font: {
                      family: 'sans-serif', 
                      size: 20,
                    }
                  },
                  legend: {
                    display: false,
                  }
                },
                responsive: true,
                scales: {
                  y: {
                    beginAtZero: true, 
                    max: 100, 
                  }, 
                  x: {
                    grid: {
                      display: false,
                    }
                  }
                }
              }
            });
          }
        }

        // Create the graph
        sampleChartClass.ChartData(ctx, 'bar', labels, values); 
      });
    </script>
</x-app-layout>