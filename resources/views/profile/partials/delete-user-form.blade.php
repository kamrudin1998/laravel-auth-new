<section class="mt-10">

    <h2 class="text-lg font-semibold text-red-500 mb-2">
        Delete Account
    </h2>

    <p class="text-sm text-red-400 mb-4">
        Once your account is deleted, all data will be permanently removed.
    </p>

    <form method="POST"
          action="{{ route('profile.destroy') }}"
          class="bg-slate-800 border border-red-700 rounded-xl p-6">

        @csrf
        @method('DELETE')

        <label class="block text-sm text-gray-300 mb-2">
            Enter your password to confirm
        </label>

        <input
            type="password"
            name="password"
            required
            class="w-full bg-slate-900 border border-red-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-red-500"
            placeholder="Your password"
        />

        @error('password')
            <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
        @enderror

        <div class="mt-6 flex gap-3">
            <button
                type="submit"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg text-white font-semibold transition">
                Confirm Delete
            </button>

            <a href="{{ route('dashboard') }}"
               class="px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white transition">
                Cancel
            </a>
        </div>

    </form>

</section>
