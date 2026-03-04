@extends('backend.app.layout')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-lg mb-5 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-1">Dashboard</h1>
        <p class="text-gray-600 text-sm">Welcome back! Here's what's happening with your site.</p>
    </div>

    <!-- Welcome Card -->
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-10 rounded-xl shadow-xl mb-8">
        <h2 class="text-3xl font-bold mb-2">👋 Hello, {{ $user->name }}!</h2>
        <p class="text-base opacity-90">You are logged in as <strong class="font-bold">{{ strtoupper($user->role) }}</strong>. Manage your content and settings from here.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-5 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 border-l-4 border-indigo-500">
            <div class="flex justify-between items-center mb-2">
                <div class="text-sm font-medium text-gray-600">Total Users</div>
                <div class="w-10 h-10 bg-indigo-100 text-indigo-500 rounded-lg flex items-center justify-center text-xl">
                    👥
                </div>
            </div>
            <div class="text-4xl font-bold text-gray-900">{{ $stats['total_users'] }}</div>
        </div>

        <!-- Total Pages Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 border-l-4 border-emerald-500">
            <div class="flex justify-between items-center mb-2">
                <div class="text-sm font-medium text-gray-600">Total Pages</div>
                <div class="w-10 h-10 bg-emerald-100 text-emerald-500 rounded-lg flex items-center justify-center text-xl">
                    📄
                </div>
            </div>
            <div class="text-4xl font-bold text-gray-900">{{ $stats['total_pages'] }}</div>
        </div>
    </div>

    <!-- Login History & Quick Actions Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
        <!-- Login History Card (2 columns) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">📜 Login History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Login Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Agent</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($loginHistory as $index => $history)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-indigo-600 font-semibold text-sm">
                                                {{ strtoupper(substr($history->user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $history->user->name }}</p>
                                            <p class="text-xs text-gray-500 capitalize">{{ $history->user->role }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $history->login_time->format('Y-m-d') }}</div>
                                    <div class="text-xs text-gray-500">{{ $history->login_time->format('H:i:s') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-mono">
                                        {{ $history->ip_address }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $history->user_agent }}">
                                    {{ Str::limit($history->user_agent, 50) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p>No login history available</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions Card (1 column) -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-5">🚀 Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('backend.pages.index') }}" class="block bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white p-4 rounded-lg text-center font-medium transition-all duration-300 hover:shadow-lg">
                    📄 Manage Pages
                </a>
                <a href="{{ route('backend.users.index') }}" class="block bg-gray-100 hover:bg-indigo-500 hover:text-white text-gray-700 p-4 rounded-lg text-center font-medium transition-all duration-300">
                    👥 Manage Users
                </a>
                <a href="#" class="block bg-gray-100 hover:bg-indigo-500 hover:text-white text-gray-700 p-4 rounded-lg text-center font-medium transition-all duration-300">
                    ⚙️ Settings
                </a>
                {{-- <a href="#" class="block bg-gray-100 hover:bg-indigo-500 hover:text-white text-gray-700 p-4 rounded-lg text-center font-medium transition-all duration-300">
                    📊 Reports
                </a> --}}
            </div>
        </div>
    </div>
</div>
@endsection
