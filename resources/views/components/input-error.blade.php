@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-400 dark:text-red-400 space-y-1 flex flex-col']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1">
                <i class="fas fa-times-circle"></i> {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
