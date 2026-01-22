<div>
    <nav class="bg-white shadow-md border-b-2 border-blue-100 sticky top-0 z-40">
        <div class="px-8 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <h1 class="text-2xl font-bold text-blue-900">Sistem Keuangan Grosir</h1>
            </div>

            <div class="flex items-center space-x-6">

                <div class="h-6 border-l border-gray-300"></div>

                <div
                    class="flex items-center space-x-3 cursor-pointer hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->nama }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full border-2 border-blue-500 bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
