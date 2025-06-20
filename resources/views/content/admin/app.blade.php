<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex h-screen">
    <aside class="w-64 bg-gray-800 text-white flex flex-col rounded-r-lg shadow-lg">
        <div class="p-6 text-2xl font-bold text-center border-b border-gray-700">
            Panel Admin
        </div>
        <nav class="flex-1 px-4 py-6">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded-lg transition duration-200 hover:bg-gray-700 {{ Request::routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="block py-2.5 px-4 rounded-lg transition duration-200 hover:bg-gray-700 {{ Request::routeIs('admin.users') ? 'bg-gray-700' : '' }}">
                Pengguna
            </a>
            <a href="{{ route('admin.news') }}" class="block py-2.5 px-4 rounded-lg transition duration-200 hover:bg-gray-700 {{ Request::routeIs('admin.news') ? 'bg-gray-700' : '' }}">
                Berita
            </a>
            <a href="{{ route('admin.categories') }}" class="block py-2.5 px-4 rounded-lg transition duration-200 hover:bg-gray-700 {{ Request::routeIs('admin.categories') ? 'bg-gray-700' : '' }}">
                Kategori
            </a>
            <div class="border-t border-gray-700 my-4"></div>
            <a href="{{ route('logout') }}" class="block py-2.5 px-4 rounded-lg transition duration-200 hover:bg-red-600 bg-red-500"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between p-6 bg-white shadow-md rounded-bl-lg">
            <h1 class="text-3xl font-semibold text-gray-800">@yield('title', 'Dashboard Admin')</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Selamat datang, {{ Auth::user()->name ?? 'Admin' }}!</span>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
