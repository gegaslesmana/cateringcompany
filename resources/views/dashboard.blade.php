<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-indigo-600 dark:text-indigo-400 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Welcome Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col items-center transition-transform transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-indigo-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Welcome Back!</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-center">You're logged in and ready to manage your tasks.</p>
                </div>

                <!-- User Info Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col justify-center transition-transform transform hover:scale-105">
                    <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 mb-3">User Info</h3>
                    <ul class="text-gray-700 dark:text-gray-300 space-y-1">
                        <li><strong>Name:</strong> {{ auth()->user()->name }}</li>
                        <li><strong>Email:</strong> {{ auth()->user()->email }}</li>
                        <li><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</li>
                        <li><strong>Plant ID:</strong> {{ auth()->user()->plant_id ?? '-' }}</li>
                    </ul>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col justify-center transition-transform transform hover:scale-105">
                    <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 mb-3">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('operator.orders.index') }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md font-semibold transition">Manage Orders</a>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block text-center bg-red-600 hover:bg-red-700 text-white py-2 rounded-md font-semibold transition">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>