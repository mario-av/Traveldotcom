@extends('layouts.app')

@section('title', 'Manage Reviews')

@section('content')
@include('partials.admin_nav')

<div class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Review Management</h1>
        </div>

        @if(session('general'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">
            {{ session('general') }}
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vacation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reviews as $review)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $review->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $review->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $review->vacation->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex text-yellow-500 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $review->content }}">
                                {{ $review->content }}
                            </div>
                            @if($review->histories->count() > 0)
                            <button onclick="document.getElementById('hist-admin-{{ $review->id }}').classList.toggle('hidden')" class="text-[10px] text-blue-600 hover:underline flex items-center mt-1">
                                <i class="bi bi-clock-history me-1"></i>View History ({{ $review->histories->count() }})
                            </button>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($review->approved)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {{-- Actions --}}
                            <div class="flex items-center justify-end space-x-3">
                                @if(!$review->approved)
                                <form action="{{ route('admin.review.approve', $review) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-700 font-bold text-xs uppercase" title="Approve Review">
                                        Approve
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('review.edit', $review) }}" class="text-gray-400 hover:text-yellow-600 transition" title="Edit Review">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>
                                <form action="{{ route('review.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Delete Review">
                                        <i class="bi bi-trash3 text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @if($review->histories->count() > 0)
                    <tr id="hist-admin-{{ $review->id }}" class="hidden bg-gray-50">
                        <td colspan="6" class="px-6 py-4">
                            <div class="text-xs font-bold text-gray-500 uppercase mb-3 px-4">Edit History</div>
                            <div class="space-y-4 pl-8 border-l-2 border-blue-200">
                                @foreach($review->histories as $history)
                                <div class="bg-white p-3 rounded shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="flex text-yellow-500 text-[10px]">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $history->rating ? '-fill' : '' }}"></i>
                                                @endfor
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-mono">{{ $history->created_at->format('Y-m-d H:i:s') }}</span>
                                    </div>
                                    <p class="text-gray-700 italic">"{{ $history->content }}"</p>
                                </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection