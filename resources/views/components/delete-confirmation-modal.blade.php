@props(['route', 'title', 'description', 'id'])

<div id="popup-modal-[{{ $id }}]" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="absolute top-3 left-4 font-bold text-2xl text-gray text-left">{{ $title }}</div>
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-[{{ $id }}]">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="pt-12 p-4">
                <hr/>
                <div class="flex justify-center mt-2">
                    <div class="flex h-12 w-12 bg-red-50 rounded-full my-2 items-center justify-center">
                        <i class="fa-regular fa-triangle-exclamation fa-xl text-red-600"></i>
                    </div>
                </div>
                <h3 class="mb-5 text-md text-center text-gray-500 dark:text-gray-400">{{ $description }}</h3>
                <div class="w-full justify-end items-center flex">
                    <button data-modal-hide="popup-modal-[{{ $id }}]" type="button" class="text-gray-500 bg-white mr-2 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-md border border-gray-200 text-xs font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">CANCEL</button>
                    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <button data-modal-hide="popup-modal-[{{ $id }}]" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-md text-xs inline-flex items-center px-5 py-2.5 text-center mr-2">
                            DELETE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>