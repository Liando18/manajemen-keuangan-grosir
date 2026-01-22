<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Informasi Keuangan Grosir Netral</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
</head>

<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-50">
        <livewire:components.sidebar />

        <div class="flex-1 ml-72 flex flex-col h-screen">
            <livewire:components.navbar />

            <main class="flex-1 overflow-auto">
                {{ $slot }}
            </main>

            <livewire:components.footer />
        </div>
    </div>

    <script>
        if (window.innerWidth < 1024) {
            const sidebar = document.querySelector('aside');
            sidebar.style.transform = 'translateX(-100%)';
        }
    </script>

    @livewireScripts
</body>

</html>
