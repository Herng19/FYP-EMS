<table class="rounded-lg mt-4 bg-white drop-shadow-[0px_0px_12px_rgba(185,185,185,0.25)] w-full">
    <thead class="w-full">
        <tr class="flex self-stretch mx-8 mt-2 border-b">
            <th class="my-4 mx-4 text-primary-700 text-sm font-bold w-4">No.</th>
            @foreach ($headers as $header)
                <th class="my-4 text-primary-700 text-sm font-bold text-left w-1/3">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    {{ $slot }}
</table>