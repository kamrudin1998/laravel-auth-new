@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 bg-green-900 border border-green-700 rounded-lg text-green-200 font-medium text-sm flex items-center gap-2']) }}>
        <i class="fas fa-check-circle"></i>
        {{ $status }}
    </div>
@endif
