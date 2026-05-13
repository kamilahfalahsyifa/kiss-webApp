<div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-100">
    <div class="flex items-center justify-between gap-4">
        <div>
            <p class="text-xs sm:text-sm text-gray-500 mb-1">{{ $label }}</p>
            <h3 class="text-2xl sm:text-3xl font-bold {{ $color ?? 'text-maroon' }}">{{ $value }}</h3>
        </div>
        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-pink-bg rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="{{ $icon ?? 'fas fa-box' }} {{ $iconColor ?? 'text-maroon' }} text-xl sm:text-2xl"></i>
        </div>
    </div>
</div>