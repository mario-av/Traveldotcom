@php
$currentRoute = Route::currentRouteName();
@endphp

<div class="bg-white border-b border-gray-200 mb-8 sticky top-20 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-8 overflow-x-auto no-scrollbar py-1">
            <a href="{{ route('vacation.index') }}"
                class="flex items-center space-x-2 py-4 px-1 border-b-2 text-sm font-medium transition whitespace-nowrap
               {{ str_contains($currentRoute, 'vacation.') ? 'border-rose-500 text-rose-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="bi bi-airplane"></i>
                <span>Vacations</span>
            </a>

            @if(Auth::user()->rol === 'admin')
            <a href="{{ route('user.index') }}"
                class="flex items-center space-x-2 py-4 px-1 border-b-2 text-sm font-medium transition whitespace-nowrap
               {{ str_contains($currentRoute, 'user.') ? 'border-rose-500 text-rose-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>

            <a href="{{ route('admin.review.index') }}"
                class="flex items-center space-x-2 py-4 px-1 border-b-2 text-sm font-medium transition whitespace-nowrap
               {{ str_contains($currentRoute, 'review.') ? 'border-rose-500 text-rose-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="bi bi-chat-left-quote"></i>
                <span>Reviews</span>
            </a>

            <a href="{{ route('category.index') }}"
                class="flex items-center space-x-2 py-4 px-1 border-b-2 text-sm font-medium transition whitespace-nowrap
               {{ str_contains($currentRoute, 'category.') ? 'border-rose-500 text-rose-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="bi bi-tags"></i>
                <span>Categories</span>
            </a>
            @endif
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>