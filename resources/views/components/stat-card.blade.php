<div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 mb-1">{{ $label }}</p>
            <h3 class="text-3xl font-bold {{ $color ?? 'text-maroon' }}">{{ $value }}</h3>
        </div>
        <div class="w-14 h-14 bg-pink-bg rounded-xl flex items-center justify-center">
            <i class="{{ $icon ?? 'fas fa-box' }} {{ $iconColor ?? 'text-maroon' }} text-2xl"></i>
        </div>
    </div>
</div>