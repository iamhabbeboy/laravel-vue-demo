<template>
    <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
        <!-- component -->
        <div
            class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col"
        >
            <h1 class="text-gray-600 py-5 font-bold text-3xl"> Login </h1>
            <div class="mb-4">
                <label
                    class="block text-grey-darker text-sm font-bold mb-2"
                    for="username"
                >
                    Email Address
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                    id="username"
                    type="text"
                    placeholder=""
                />
            </div>
            <div class="mb-4">
                <label
                    class="block text-grey-darker text-sm font-bold mb-2"
                    for="password"
                >
                    Password
                </label>
                <input
                    class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                    id="password"
                    type="password"
                />
                <!-- <p class="text-red text-xs italic">Please choose a password.</p> -->
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                    type="button"
                >
                    Sign In
                </button>
                <a
                    class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                    href="#"
                >
                    Forgot Password?
                </a>
            </div>
        </div>
    </div>
</template>

<script></script>
