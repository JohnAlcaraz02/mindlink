<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindLink - Mental Health Support Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
      window.axios = axios;
      window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    </script>
    @stack('styles')
 </head>
 <body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 w-80 h-screen bg-white shadow-xl border-r border-gray-200 z-20 flex flex-col">
            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-6">
                    <!-- Logo/Brand -->
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 flex items-center justify-center">
                            <img src="{{ asset('images/batstateu-logo.png') }}" alt="BatStateU Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">MindLink</h1>
                            <p class="text-sm text-gray-500">Mental Health Support Hub</p>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-red-600 to-red-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('journal.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('journal.*') ? 'bg-gradient-to-r from-red-600 to-red-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="font-medium">My Journal</span>
                        </a>

                        <a href="{{ route('chat.anonymous') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('chat.anonymous') ? 'bg-gradient-to-r from-red-600 to-red-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span class="font-medium">Anonymous Chat</span>
                        </a>

                        <a href="{{ route('resources.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('resources.*') ? 'bg-gradient-to-r from-red-600 to-red-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-medium">Resources</span>
                        </a>

                        <a href="{{ route('profile.show') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-red-600 to-red-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="font-medium">My Profile</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Info at Bottom (Fixed) -->
            <div class="w-80 h-20 px-6 border-t border-gray-200 bg-white flex-shrink-0 flex items-center">
                <div class="flex items-center justify-between w-full">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->user_type }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Vertical Divider -->
<div class="fixed left-80 top-0 h-screen w-[1px] bg-gray-300 z-30 pointer-events-none"></div>

        <!-- Main Content -->
        <main class="flex-1 bg-white min-h-screen overflow-y-auto ml-80 flex flex-col">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>