@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border-2 border-slate-600 dark:border-slate-600 bg-slate-700 dark:bg-slate-700 text-white dark:text-white focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500 rounded-lg shadow-sm transition']) }}>
