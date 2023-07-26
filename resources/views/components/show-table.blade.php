<table class="rounded-lg mt-4 pt-2 pb-4 bg-white drop-shadow-[0px_0px_12px_rgba(215,215,215,0.25)] w-full">
    <thead class="border-b w-full">
        <tr class="flex self-stretch">
            <th class="px-4 py-2 text-primary-700 text-sm font-bold">No.</th>
            @foreach ($headers as $header)
                <th class="px-4 py-2 mx-2 text-primary-700 text-sm font-bold text-left grow">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>