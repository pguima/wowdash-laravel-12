<section class="bg-white dark:bg-dark-2 flex flex-wrap min-h-[100vh]">
    <div class="lg:w-1/2 lg:block hidden">
        <div class="flex items-center flex-col h-full justify-center">
            <img src="{{ asset('assets/images/auth/auth-img.png') }}" alt="">
        </div>
    </div>
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
        <div class="lg:max-w-[464px] mx-auto w-full">
            <div>
                <a href="{{ route('home') }}" class="mb-2.5 max-w-[290px]">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="">
                </a>
                <h4 class="mb-3">Sign In to your Account</h4>
                <p class="mb-8 text-secondary-light text-lg">Welcome back! please enter your detail</p>
            </div>
            <form wire:submit.prevent="login">
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" wire:model="email"
                        class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                        placeholder="Email">
                    @error('email') <span class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="relative mb-5" x-data="{ show: false }">
                    <div class="icon-field">
                        <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span>
                        <input :type="show ? 'text' : 'password'" wire:model="password"
                            class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                            placeholder="Password">
                    </div>
                    <span @click="show = !show"
                        class="cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light">
                        <iconify-icon :icon="show ? 'ri:eye-off-line' : 'ri:eye-line'"></iconify-icon>
                    </span>
                    @error('password') <span class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="mt-7">
                    <div class="flex justify-between gap-2">
                        <div class="flex items-center">
                            <input class="form-check-input border border-neutral-300" type="checkbox"
                                wire:model="remember" id="remember">
                            <label class="ps-2" for="remember">Remember me </label>
                        </div>
                        <a href="{{ route('password.request') }}"
                            class="text-primary-600 font-medium hover:underline">Forgot Password?</a>
                    </div>
                </div>

                <button type="submit"
                    class="btn btn-primary justify-center text-sm btn-sm px-3 py-4 w-full rounded-xl mt-8"> Sign
                    In</button>

                <div
                    class="mt-8 center-border-horizontal text-center relative before:absolute before:w-full before:h-[1px] before:top-1/2 before:-translate-y-1/2 before:bg-neutral-300 before:start-0">
                    <span class="bg-white dark:bg-dark-2 z-[2] relative px-4">Or sign in with</span>
                </div>
                <div class="mt-8 flex items-center gap-3">
                    <button type="button"
                        class="font-semibold text-neutral-600 dark:text-neutral-200 py-4 px-6 w-1/2 border rounded-xl text-base flex items-center justify-center gap-3 line-height-1 hover:bg-primary-50">
                        <iconify-icon icon="ic:baseline-facebook"
                            class="text-primary-600 text-xl line-height-1"></iconify-icon>
                        Facebook
                    </button>
                    <button type="button"
                        class="font-semibold text-neutral-600 dark:text-neutral-200 py-4 px-6 w-1/2 border rounded-xl text-base flex items-center justify-center gap-3 line-height-1 hover:bg-primary-50">
                        <iconify-icon icon="logos:google-icon"
                            class="text-primary-600 text-xl line-height-1"></iconify-icon>
                        Google
                    </button>
                </div>
                <div class="mt-8 text-center text-sm">
                    <p class="mb-0">Don't have an account? <a href="{{ route('register') }}"
                            class="text-primary-600 font-semibold hover:underline">Sign Up</a></p>
                </div>

            </form>
        </div>
    </div>
</section>