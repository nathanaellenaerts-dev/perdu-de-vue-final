@if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm" role="alert">
        <p class="font-medium">{{ session('success') }}</p>
    </div>
@endif
