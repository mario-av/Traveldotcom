@extends('layouts.app')

@section('title', 'Edit Vacation - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('vacation.index') }}" class="text-gray-500 hover:text-gray-700 me-4">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Edit Vacation</h2>
            </div>

            <form method="POST" action="{{ route('vacation.update', $vacation) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Title --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $vacation->title) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                        @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea id="description" name="description" rows="4" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $vacation->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $vacation->location) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror">
                        @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select id="category_id" name="category_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $vacation->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $vacation->price) }}" step="0.01" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                        @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Duration --}}
                    <div>
                        <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-1">Duration (days) *</label>
                        <input type="number" id="duration_days" name="duration_days" value="{{ old('duration_days', $vacation->duration_days) }}" min="1" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('duration_days') border-red-500 @enderror">
                        @error('duration_days')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Start Date --}}
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $vacation->start_date?->format('Y-m-d')) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Available Slots --}}
                    <div>
                        <label for="available_slots" class="block text-sm font-medium text-gray-700 mb-1">Available Slots *</label>
                        <input type="number" id="available_slots" name="available_slots" value="{{ old('available_slots', $vacation->available_slots) }}" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('available_slots') border-red-500 @enderror">
                        @error('available_slots')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Existing Photos --}}
                    @if($vacation->photos->count() > 0)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Photos</label>
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($vacation->photos as $photo)
                            <div class="relative group">
                                <img src="{{ url('storage/' . $photo->path) }}" alt="Photo" class="w-full h-24 object-cover rounded-lg">
                                <label class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition">
                                    <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}" class="hidden">
                                    <i class="bi bi-x text-sm"></i>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Click X to mark photos for deletion</p>
                    </div>
                    @endif

                    {{-- New Photos --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Add New Photos</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                            <input type="file" id="photos" name="photos[]" multiple accept="image/*" class="hidden">
                            <label for="photos" class="cursor-pointer">
                                <i class="bi bi-cloud-upload text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Click to upload or drag and drop</p>
                            </label>
                        </div>
                    </div>

                    {{-- Toggles --}}
                    <div class="md:col-span-2 flex space-x-8">
                        <label class="flex items-center">
                            <input type="checkbox" name="active" value="1" {{ old('active', $vacation->active) ? 'checked' : '' }}
                                class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="featured" value="1" {{ old('featured', $vacation->featured) ? 'checked' : '' }}
                                class="h-5 w-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                            <span class="ml-2 text-gray-700">Featured</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex space-x-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('vacation.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection