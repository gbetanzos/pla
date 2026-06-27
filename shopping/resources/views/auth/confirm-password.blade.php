<x-guest-layout>
    <section class="mb-4 text-secondary">
        <h2 class="h4 mb-0"><i class="fas fa-shield-alt me-2"></i> Confirm your password</h2>
    </section>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="form-control form-outline"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">
                Confirm
            </button>
        </div>
    </form>
</x-guest-layout>
