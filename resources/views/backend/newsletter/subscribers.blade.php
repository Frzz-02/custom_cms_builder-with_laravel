@extends('backend.app.layout')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Newsletter Subscribers</h1>
                <p class="text-slate-600 mt-1">Manage your email subscribers</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-indigo-600">{{ $subscribers->total() }}</div>
                <div class="text-sm text-slate-600">Total Subscribers</div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Subscribers Table -->
    @if($subscribers->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Email Address</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Subscribed Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @foreach($subscribers as $index => $subscriber)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $subscribers->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium text-slate-900">{{ $subscriber->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($subscriber->status === 'Subscribed')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Subscribed</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-800">{{ $subscriber->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">{{ $subscriber->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-slate-500">{{ $subscriber->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('backend.newsletter.subscribers.destroy', $subscriber) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $subscribers->links() }}
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-12">
        <div class="text-center">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">No Subscribers Yet</h3>
            <p class="text-slate-600">Newsletter subscribers will appear here once they sign up</p>
        </div>
    </div>
    @endif
</div>
@endsection
