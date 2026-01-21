<nav class="bg-gradient-to-r from-slate-800 to-slate-900 border-b border-slate-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- LEFT : LOGO + NAV LINKS --}}
            <div class="flex items-center gap-8">

                {{-- TODOAPP = HOME / DASHBOARD --}}
                <x-nav-link
                    :href="route('dashboard')"
                    :active="request()->routeIs('dashboard')"
                    class="flex items-center gap-3 text-white hover:text-blue-400 font-bold text-lg transition">
                    <div class="text-2xl text-blue-400">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <span>Dashboard</span>
                </x-nav-link>

                {{-- MY TASKS --}}
                <x-nav-link
                    :href="route('todo.index')"
                    :active="request()->routeIs('todo.*')"
                    class="text-white hover:text-blue-400 font-semibold flex items-center gap-2 transition">
                    <i class="fas fa-list"></i> My Tasks
                </x-nav-link>

            </div>

            {{-- RIGHT : USER DROPDOWN --}}
            <div class="flex items-center">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="flex items-center gap-3 px-4 py-2 rounded-lg
                                   text-sm font-medium text-white
                                   hover:bg-slate-700 focus:outline-none transition">

                            {{-- PROFILE PHOTO --}}
                            <img
                                src="{{ Auth::user()->profile_photo
                                    ? asset('storage/' . Auth::user()->profile_photo)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                class="rounded-full border-2 border-blue-400"
                                width="36"
                                height="36"
                                style="object-fit:cover;">

                            {{-- USER NAME --}}
                            <span>{{ Auth::user()->name }}</span>

                            {{-- DROPDOWN ICON --}}
                            <i class="fas fa-chevron-down text-xs opacity-75"></i>
                        </button>
                    </x-slot>

                    {{-- DROPDOWN CONTENT --}}
                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            <i class="fas fa-user-circle"></i> Profile Settings
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center gap-2">
                                <i class="fas fa-sign-out-alt"></i> Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>
</nav>
