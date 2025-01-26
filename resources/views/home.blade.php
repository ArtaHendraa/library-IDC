<x-app-layout>
    <div class="flex flex-wrap items-center justify-center gap-5 py-5">
        <div class="bg-[#E7E9F1] p-3 rounded-md">
            <img class="rounded-md w-52 h-60" src="/no-image.jpg" alt="">
            <h1 class="py-2 text-lg font-semibold">Goodbye Eri</h1>
            <div class="flex items-center gap-2">
                <button class="w-full px-2 py-1 text-center text-white bg-blue-500 rounded-md"
                    onclick="window.location.href='/edit'">
                    Edit
                </button>
                <button class="w-full px-2 py-1 text-center text-white bg-red-500 rounded-md">
                    Delete
                </button>
            </div>
            <button class="w-full px-2 py-1 mt-2 text-center text-white bg-green-500 rounded-md">
                Detail Book
            </button>
        </div>
    </div>
</x-app-layout>
