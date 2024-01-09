<table class="rounded-md mt-4 bg-white drop-shadow-[0px_0px_12px_rgba(120,120,120,0.15)] w-full">
    <thead class="w-full">
        <tr class="flex self-stretch px-8 mt-2 border-b-2 border-b-primary-200">
            <th class="my-4 mx-4 text-primary-700 text-sm font-bold w-4">No.</th>
            @foreach ($headers as $header)
                @if($header == 'Action' || $header == 'PSM Year')
                    <th class="my-4 text-primary-700 text-sm font-bold text-center w-1/3 uppercase">{{ $header }}</th>
                @else
                    <th class="my-4 text-primary-700 text-sm font-bold text-left w-1/3 uppercase">{{ $header }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    {{ $slot }}
</table>