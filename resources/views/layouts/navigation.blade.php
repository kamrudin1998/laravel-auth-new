<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- LEFT : LOGO + NAV LINKS --}}
            <div class="flex items-center gap-6">

                {{-- TODOAPP = HOME / DASHBOARD --}}
                <x-nav-link
                    :href="route('dashboard')"
                    :active="request()->routeIs('dashboard')"
                    class="flex items-center gap-2">
                    <x-application-logo class="block h-8 w-auto text-gray-800" />
                    <span class="font-semibold text-lg">TodoApp</span>
                </x-nav-link>

                {{-- MY TASKS --}}
                <x-nav-link
                    :href="route('todo.index')"
                    :active="request()->routeIs('todo.*')">
                    <i class="fa fa-list me-1"></i> My Tasks
                </x-nav-link>

            </div>

            {{-- RIGHT : USER DROPDOWN --}}
            <div class="flex items-center">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="flex items-center gap-2 px-3 py-2 rounded-md
                                   text-sm font-medium text-gray-700
                                   hover:bg-gray-100 focus:outline-none">

                            {{-- PROFILE PHOTO --}}
                            <img
                                src="{{ Auth::user()->profile_photo
                                    ? asset('storage/' . Auth::user()->profile_photo)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                class="rounded-full"
                                width="32"
                                height="32"
                                style="object-fit:cover;">

                            {{-- USER NAME --}}
                            <span>{{ Auth::user()->name }}</span>

                            {{-- DROPDOWN ICON --}}
                            <i class="fa fa-chevron-down text-xs"></i>
                        </button>
                    </x-slot>

                    {{-- DROPDOWN CONTENT --}}
                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa fa-user me-2"></i> Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa fa-sign-out-alt me-2"></i> Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>
</nav>
