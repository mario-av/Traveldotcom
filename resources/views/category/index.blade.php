@extends('layouts.app')

@section('title', 'Manage Categories - Admin')

@section('content')
@include('partials.admin_nav')

<div class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Categories</h1>
            <a href="{{ route('category.create') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-lg transition font-semibold shadow-sm">
                <i class="bi bi-plus-lg me-1"></i>Add Category
            </a>
        </div>

        @if(session('general'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">
            <i class="bi bi-check-circle me-2"></i>{{ session('general') }}
        </div>
        @endif

        @error('general')
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
        </div>
        @enderror

        
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Vacations</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-gray-800">{{ $category->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 line-clamp-1" title="{{ $category->description }}">
                                    {{ $category->description ?: 'No description' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    {{ $category->vacations_count }} items
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('category.edit', $category) }}" class="text-gray-400 hover:text-yellow-600 transition" title="Edit">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <form action="{{ route('category.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category? This might affect vacations using it.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                            <i class="bi bi-trash3 text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                No categories found. Let's create the first one!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection