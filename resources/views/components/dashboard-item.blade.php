<div class="flex px-4 py-4 bg-gray-100 text-gray rounded-md mx-8 w-1/3 drop-shadow-[0px_0px_24px_rgba(120,120,120,0.15)]">
    {{ $icon }}
    <div class="flex flex-col mt-2 mx-2 grow justify-start">
        <div class="flex">
            <p class="text-start text-sm text-gray-500 font-semibold">{{ $title }}</p>
        </div>
        <div class="flex justify-center">
            <p class="text-start font-bold text-3xl mt-2">{{ $data }}</p>
        </div>
    </div>
</div>