<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

    {{-- Graph --}}
    <div class="grid grid-cols-3 gap-4 mx-12" style="max-height: 80vh;">
      <div class="col-span-2">
        <canvas id="myChart" class="rounded-md shadow p-8 bg-white"></canvas>
      </div>

      {{-- If is coordinator, display all student's grade and co level --}}
      @role('coordinator')
      <div class="flex flex-col">
        <div class="h-1/2 mb-2">
          <canvas id="graph1" class="rounded-md shadow p-8 bg-white"></canvas>
        </div>
        <div class="h-1/2">
          <canvas id="graph2" class="rounded-md shadow p-8 bg-white"></canvas>
        </div>
      </div>
      @endrole
    </div>

    {{-- Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      $(document).ready(function() {
        var barChartClass, pieChartClass;
        const barChart = document.getElementById('myChart');
        const pieChart1 = document.getElementById('graph1');
        const pieChart2 = document.getElementById('graph2');

        // Graph Settings
        barChartClass = {
          ChartData:function(ctx, title, bgc, labels, data){
            new Chart(ctx, {
              type: 'bar',
              data: {
                labels: labels,
                datasets: [{
                  label: 'Student Marks',
                  data: data,
                  borderWidth: 1, 
                  borderRadius: 20,
                  backgroundColor:bgc,
                  width: 10, 
                }]
              },
              options: {
                maintainAspectRatio: false,
                plugins: {
                  title: {
                    color: '#006061', 
                    align: 'start', 
                    display: true,
                    text: title,
                    padding: {
                      bottom: 30
                    },
                    font: {
                      family: "'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif', 'FontAwesome'", 
                      size: 20,
                      weight: 'bold', 
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

        pieChartClass = {
          ChartData:function(ctx, title, label, labels, data){
            new Chart(ctx, {
              type: 'pie',
              data: {
                labels: labels,
                datasets: [{
                  label: label,
                  data: data,
                  backgroundColor: [
                    '#31b9b1',
                    '#12a4b8', 
                    '#1a488f', 
                    '#721a8f',
                    '#B81270',  
                    '#C0040E', 
                    '#D68111', 
                    '#F0BF1F', 
                  ],
                  width: 10, 
                }]
              },
              options: {
                maintainAspectRatio: false,
                plugins: {
                  title: {
                    color: '#006061', 
                    align: 'start', 
                    display: true,
                    text: title,
                    padding: {
                      bottom: 30
                    },
                    font: {
                      family: "'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif', 'FontAwesome'", 
                      size: 20,
                      weight: 'bold', 
                    }
                  },
                  legend: {
                    display: true,
                    position: 'right',
                    labels: {
                      usePointStyle: true,
                      pointStyle: 'circle',
                    }
                  }
                },
                responsive: true,
              }
            });
          }
        }

        var supervisee = Object.keys(@json($all_supervisee_marks));
        var supervisee_marks = Object.values(@json($all_supervisee_marks));

        var grades = Object.keys(@json($all_students_grade));
        var grades_count = Object.values(@json($all_students_grade));

        var co_level = Object.keys(@json($all_students_co));
        var co_level_count = Object.values(@json($all_students_co));

        var bgc = []; 

        const max = Math.max(...supervisee_marks);
        console.log(max);
        const highestValueColor = supervisee_marks.map((value) => { 
          const color = value === max ? '#00A0A1' : '#ececec';
          bgc.push(color); 
        });

        // Create the graph
        barChartClass.ChartData(barChart, '\ue473 Supervisee Marks', bgc, supervisee, supervisee_marks); 
        pieChartClass.ChartData(pieChart1, '\ue474 Grades', 'Student Counts', grades, grades_count);
        pieChartClass.ChartData(pieChart2, '\uf200 Students Achieve 50% CO Marks', 'Students achieve CO level', co_level, co_level_count);
      });
    </script>
</x-app-layout>