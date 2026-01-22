<div>
    <div class="bg-white rounded-lg shadow-xl p-8">
        <div class="text-center mb-8">
            <div class="inline-block bg-blue-600 text-white p-4 rounded-full mb-4">
                <i class="fas fa-wallet text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Grosir Netral</h1>
            <p class="text-gray-600 text-sm mt-2">Masukan Email dan Password</p>
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

        <form wire:submit.prevent="login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <div class="relative">
                    <input type="email" wire:model="email" required
                        class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="nama@example.com">
                    <i class="fas fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <div class="relative">
                    <input type="password" wire:model="password" required
                        class="w-full px-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="••••••••">
                    <i class="fas fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="rememberMe"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>
                <a href="{{ route('lupa-password') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Lupa password?
                </a>
            </div>

            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 disabled:cursor-not-allowed text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <span wire:loading.remove>
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </span>
                <span wire:loading>
                    <i class="fas fa-spinner fa-spin"></i> Sedang login...
                </span>
            </button>
        </form>
    </div>

    <script>
        const rememberCheckbox = document.getElementById('rememberMe');
        const emailInput = document.querySelector('input[type="email"]');
        const passwordInput = document.querySelector('input[type="password"]');

        if (localStorage.getItem('rememberMe') === 'true') {
            rememberCheckbox.checked = true;
            emailInput.value = localStorage.getItem('rememberedEmail') || '';
            passwordInput.value = localStorage.getItem('rememberedPassword') || '';
        }

        rememberCheckbox.addEventListener('change', () => {
            if (rememberCheckbox.checked) {
                localStorage.setItem('rememberMe', 'true');
                localStorage.setItem('rememberedEmail', emailInput.value);
                localStorage.setItem('rememberedPassword', passwordInput.value);
            } else {
                localStorage.removeItem('rememberMe');
                localStorage.removeItem('rememberedEmail');
                localStorage.removeItem('rememberedPassword');
            }
        });

        emailInput.addEventListener('change', () => {
            if (rememberCheckbox.checked) {
                localStorage.setItem('rememberedEmail', emailInput.value);
            }
        });

        passwordInput.addEventListener('change', () => {
            if (rememberCheckbox.checked) {
                localStorage.setItem('rememberedPassword', passwordInput.value);
            }
        });

        function checkAndShowToast() {
            if (typeof window.showToast !== 'function') {
                setTimeout(checkAndShowToast, 100);
                return;
            }

            const alertBox = document.querySelector('[class*="bg-red-50"]');
            if (alertBox) {
                const message = alertBox.textContent.trim();
                window.showToast(message, 'error');
            }

            const successBox = document.querySelector('[class*="bg-green-50"]');
            if (successBox) {
                const message = successBox.textContent.trim();
                window.showToast(message, 'success');
            }
        }

        setTimeout(checkAndShowToast, 200);
    </script>
</div>
