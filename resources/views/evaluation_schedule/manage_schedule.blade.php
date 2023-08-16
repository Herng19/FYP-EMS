<x-app-layout>
    <x-slot name="header">
        {{ __('Evaluation Schedule') }}
    </x-slot>
    <div class="mx-12 mt-4">
        <form action="" method="POST">
            @csrf
            <div class="flex justify-between w-full items-center">
                <input type="date" name="date" id="date" class="rounded-md border-0 text-gray-400 text-sm font-semibold drop-shadow-[0px_1px_12px_rgba(185,185,185,0.25)]"/>
                <x-button type="submit">GENERATE</x-button>
            </div>
        </form>
        <div id="table">
        <table class="my-6 bg-white w-full h-2/3 rounded-lg drop-shadow-[0px_1px_12px_rgba(185,185,185,0.25)]"  style="height: 70vh;">
            <thead>
                <tr class="flex text-gray-600 text-center text-xs font-semibold border-b justify-between px-4 items-center bg-blue-50 rounded-t-lg">
                    <th class="py-4 w-12">Slot/Venue</th>
                    @foreach( $timeslots as $timeslot)
                        <th class="w-12">{{$timeslot}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($venues as $venue) 
                    <tr class="flex text-gray-700 text-center text-xs font-semibold justify-between px-4 items-center border-b">
                        <td class="py-4 w-12 text-xs font-bold break-all">{{$venue->venue_code}}</td>
                        @foreach($timeslots as $timeslot)
                        @php $i = 0; @endphp
                            @foreach($schedules as $schedule)
                                @if($schedule->venue_id == $venue->venue_id && (date("H:i", strtotime($schedule->start_time))) == $timeslot)
                                    <td class="w-12 p-2 border-l">
                                        <a href="/evaluation schedule/edit-slot/{{$schedule->student_id}}">
                                            <div class="text-primary-700 font-bold">{{$schedule->name}}</div>
                                        </a>
                                    </td>
                                    @php $i = 1; @endphp
                                @endif
                            @endforeach
                        @php if($i == 0) { echo '<td class="w-12 border-l h-max">-</td>'; } @endphp
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>     
        </div>
    </div>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#date').on('change', function(e) {
            date = $("input[name=date]").val();         
            $.ajax({
                  type: "POST",
                  url: '/evaluation schedule',
                  data: {
                    date: date,
                  },
                  success: function(result) {
                    $('#table').html(jQuery(result).find('#table').html());
                  },
                  error: function (error) {
                    console.log(error);
                  }
            });
        })

        $(window).load(function() {
            date = document.getElementById('date').value;
            $.ajax({
                  type: "POST",
                  url: '/evaluation schedule',
                  data: {
                    date: date,
                  },
                  success: function(result) {
                    $('#table').html(jQuery(result).find('#table').html());
                  },
                  error: function (error) {
                    console.log(error);
                  }
            });
        })
    </script>
</x-app-layout>
