<div>
    <div class="bg-white rounded-lg shadow-xl p-8">
        <div class="text-center mb-8">
            <div class="inline-block bg-blue-600 text-white p-4 rounded-full mb-4">
                <i class="fas fa-lock text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Reset Password</h1>
            <p class="text-gray-600 text-sm mt-2">
                @if ($step == 1)
                    Masukan email untuk menerima kode OTP
                @elseif ($step == 2)
                    Masukan kode OTP yang telah dikirim ke email
                @else
                    Buat password baru untuk akun Anda
                @endif
            </p>
        </div>

        @if ($errorMessage)
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                <div class="flex-1">
                    <p class="text-red-600 text-sm font-medium">{{ $errorMessage }}</p>
                </div>
            </div>
        @endif

        @if ($successMessage)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                <div class="flex-1">
                    <p class="text-green-600 text-sm font-medium">{{ $successMessage }}</p>
                </div>
            </div>
        @endif

        @if ($step == 1)
            <form wire:submit.prevent="requestOtp" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <input type="email" wire:model="email" required
                            class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="nama@example.com">
                        <i
                            class="fas fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 disabled:cursor-not-allowed text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <span wire:loading.remove>
                        <i class="fas fa-paper-plane"></i> Kirim OTP
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin"></i> Mengirim...
                    </span>
                </button>
            </form>
        @elseif ($step == 2)
            <form wire:submit.prevent="verifyOtp" class="space-y-6">
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode OTP (6 digit)
                    </label>
                    <div class="relative">
                        <input type="text" wire:model="otp" maxlength="6" required
                            class="w-full px-4 py-2 border @error('otp') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-center text-2xl tracking-widest"
                            placeholder="000000">
                    </div>
                    @error('otp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-2">Kode OTP berlaku selama 10 menit</p>
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 disabled:cursor-not-allowed text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <span wire:loading.remove>
                        <i class="fas fa-check"></i> Verifikasi OTP
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin"></i> Verifikasi...
                    </span>
                </button>

                <button type="button" wire:click="kembaliKeLogin"
                    class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-200">
                    Kembali ke Login
                </button>
            </form>
        @else
            @if ($step == 3)
                <form wire:submit.prevent="resetPassword" class="space-y-6">
                    <div>
                        <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <div class="relative">
                            <input type="password" wire:model="newPassword" required
                                class="w-full px-4 py-2 border @error('newPassword') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="••••••••">
                            <i
                                class="fas fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        @error('newPassword')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input type="password" wire:model="confirmPassword" required
                                class="w-full px-4 py-2 border @error('confirmPassword') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="••••••••">
                            <i
                                class="fas fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        @error('confirmPassword')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 disabled:cursor-not-allowed text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                        <span wire:loading.remove>
                            <i class="fas fa-save"></i> Reset Password
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin"></i> Mereset...
                        </span>
                    </button>
                </form>
            @else
                <div class="text-center">
                    <div class="inline-block bg-green-100 text-green-600 p-4 rounded-full mb-4">
                        <i class="fas fa-check text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Password Berhasil Direset!</h2>
                    <p class="text-gray-600 mb-6">Silakan login dengan password baru Anda</p>
                    <a href="{{ route('login') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        Kembali ke Login
                    </a>
                </div>
            @endif
        @endif

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Kembali ke halaman login
            </a>
        </div>
    </div>
</div>
