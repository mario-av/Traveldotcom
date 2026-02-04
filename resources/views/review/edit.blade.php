@extends('layouts.app')

@section('title', 'Editar Reseña')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('vacation.show', $review->vacation_id) }}" class="text-gray-500 hover:text-gray-700 me-4">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Editar Reseña</h2>
            </div>



            <form method="POST" action="{{ route('review.update', $review) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Puntuación *</label>
                        <div class="flex space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}"
                                    {{ old('rating', $review->rating) == $i ? 'checked' : '' }}
                                    class="hidden peer">
                                <i class="bi bi-star{{ old('rating', $review->rating) >= $i ? '-fill text-yellow-400' : ' text-gray-300' }} text-2xl peer-checked:text-yellow-400 hover:text-yellow-400 transition"></i>
                                </label>
                                @endfor
                        </div>
                        @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    
                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comentario *</label>
                        <textarea id="comment" name="comment" rows="5" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 @error('comment') border-red-500 @enderror"
                            placeholder="Describe tu experiencia...">{{ old('comment', $review->content) }}</textarea>
                        @error('comment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex space-x-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition">
                        <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                    </button>
                    <a href="{{ route('vacation.show', $review->vacation_id) }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    
    document.querySelectorAll('input[name="rating"]').forEach((radio, idx) => {
        radio.addEventListener('change', function() {
            const stars = document.querySelectorAll('input[name="rating"] + i');
            stars.forEach((star, i) => {
                if (i <= idx) {
                    star.classList.remove('bi-star', 'text-gray-300');
                    star.classList.add('bi-star-fill', 'text-yellow-400');
                } else {
                    star.classList.remove('bi-star-fill', 'text-yellow-400');
                    star.classList.add('bi-star', 'text-gray-300');
                }
            });
        });
    });
</script>
@endsection