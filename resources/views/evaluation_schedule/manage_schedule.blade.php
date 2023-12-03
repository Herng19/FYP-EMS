<x-app-layout>
    <x-slot name="header">
        {{ __('Evaluation Schedule') }}
    </x-slot>

    <div class="mx-12" id="content">
        {{-- Action Message --}}
        <x-success-message/>

        {{-- Scheduling Animation --}}   
        <div id="animation" class="fixed top-0 left-0 h-full w-full z-10 hidden">
            <div role="status" class="fixed top-0 left-0 h-full w-full opacity-30 bg-black">
            </div>
            <div class="fixed top-1/2 left-1/2 z-20">
                <div class="flex-col items-center justify-center">
                    <svg aria-hidden="true" class="w-8 h-8 ml-6 text-primary-100 animate-spin dark:text-gray-600 fill-primary-700" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <div class="block text-primary-700 font-bold text-md">Scheduling...</div>
                </div>
            </div>
        </div>


        {{-- My Schedule --}}
        <div class="flex justify-end mb-2">
            <a href="/evaluation schedule/view-schedule" class="text-primary-700 font-semibold text-sm underline">My Schedule >></a>
        </div>

        {{-- Evaluation Schedule Actions --}}
        <form action="/evaluation schedule" method="POST">
            @csrf
            <div class="flex justify-between w-full items-center">
                <div class="flex">
                    <input type="date" name="date" id="date" class="parameter rounded-md border-0 text-gray-400 text-sm font-semibold drop-shadow-[0px_1px_12px_rgba(185,185,185,0.25)]" value="{{Session::get('date')}}" required/>
                    <select name="psm_year" id="psm_year" class="parameter ml-2 rounded-md border-0 bg-white text-gray-400 text-sm font-semibold drop-shadow-[0px_1px_12px_rgba(185,185,185,0.25)]" required>
                        <option value="" class="text-gray-300" default>PSM Year</option>
                        <option value="1" {{ (Session::get('psm_year') && Session::get('psm_year') == '1')? 'selected': ''; }}>1</option>
                        <option value="2" {{ (Session::get('psm_year') && Session::get('psm_year') == '2')? 'selected': ''; }}>2</option>
                    </select>
                </div>
                <div>
                    <a href="/evaluation schedule/create-slot"><x-secondary-button class="border-primary-700 border-2 font-bold text-primary-700">NEW SLOT</x-secondary-button></a>
                    <x-button type="submit" id="submit">GENERATE</x-button>
                </div>
            </div>
        </form>

        {{-- Evaluation Schedule --}}
        <div id="table">
        <table class="my-6 bg-white w-full h-2/3 rounded-md drop-shadow-[0px_1px_12px_rgba(120,120,120,0.15)]"  style="height: 70vh;">
            <thead>
                <tr class="flex text-white text-center text-xs font-semibold border-b justify-between px-4 items-center bg-primary-700 rounded-t-md">
                    <th class="py-4 w-14">Venue/Slot</th>
                    @foreach( $timeslots as $timeslot)
                        <th class="w-14">{{$timeslot}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($venues as $i => $venue) 
                    <tr class="flex text-gray-700 text-center text-xs font-semibold justify-between px-4 items-center border-b {{ ($i%2 == 1)? 'bg-primary-50': ''; }} {{ ($loop->last)? 'rounded-b-md' : ''; }}">
                        <td class="py-4 w-14 text-xs font-bold break-all">{{ ($venue->venue_code != null)? $venue->venue_code : $venue->booth_code }}</td>
                        @foreach($timeslots as $timeslot)
                        @php $i = 0; @endphp
                            @foreach($schedules as $schedule)
                                @if(($schedule->venue_id == $venue->venue_id || $schedule->venue_id == $venue->booth_id) && (date("H:i", strtotime($schedule->start_time))) == $timeslot)
                                    <td class="w-14 p-2 border-l">
                                        <a href="/evaluation schedule/edit-slot/{{$schedule->slot_id}}">
                                            <div class="text-primary-700 font-bold text-[11px] underline">{{explode(" ", $schedule->name)[0]}}</div>
                                        </a>
                                    </td>
                                    @php $i = 1; @endphp
                                @endif
                            @endforeach
                        @php if($i == 0) { echo '<td class="w-14 border-l h-max">-</td>'; } @endphp
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
        
        // Whenever date or psm year changes, update the schedule data
        $('.parameter').on('change', function(e) {
            date = $("input[name=date]").val();
            psm_year = $("select[name=psm_year]").val();

            $.ajax({
                  type: "PUT",
                  url: '/evaluation schedule',
                  data: {
                    date: date,
                    psm_year: psm_year,
                  },
                  success: function(result) {
                    $('#table').html(jQuery(result).find('#table').html());
                  },
                  error: function (error) {
                    console.log(error);
                  }
            });
        });

        // submit form when generate button is clicked
        $('form').on('submit', function(e) {
            e.preventDefault();
            date = $("input[name=date]").val();
            psm_year = $("select[name=psm_year]").val();

            $('#animation').removeClass('hidden');
            $.ajax({
                  type: "POST",
                  url: '/evaluation schedule',
                  data: {
                    date: date,
                    psm_year: psm_year,
                  },
                  success: function(result) {
                    $('#animation').addClass('hidden');
                    $('#content').html(jQuery(result).find('#content').html());
                  },
                  error: function (error) {
                    console.log(error);
                  }
            });
        });
    </script>
</x-app-layout>
