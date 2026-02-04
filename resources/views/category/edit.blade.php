@extends('layouts.app')

@section('title', 'Edit Category - Admin')

@section('content')
@include('partials.admin_nav')

<div class="py-4">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('category.index') }}" class="text-gray-500 hover:text-gray-700 me-4">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Edit Category</h2>
            </div>

            @if(session('general'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">
                <i class="bi bi-check-circle me-2"></i>{{ session('general') }}
            </div>
            @endif

            <form method="POST" action="{{ route('category.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-rose-500 @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-rose-500 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex space-x-4">
                    <button type="submit" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white py-3 rounded-lg font-semibold transition shadow-md">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('category.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection