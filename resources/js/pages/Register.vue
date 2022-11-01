<template>
    <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
        <!-- component -->
        <div
            class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col"
        >
            <h1 class="text-gray-600 py-5 font-bold text-3xl"> Create Account </h1>
            <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index">
                <li>{{value[0]}}</li>
            </ul>
            <form method="post" @submit="handleSubmit">
            <div class="mb-4 mt-3">
                <label
                    class="block text-grey-darker text-sm font-bold mb-2"
                    for="name"
                >
                   Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                    id="name"
                    type="text"
                    required
                    v-model="form.name"
                />
            </div>
            <div class="mb-4">
                <label
                    class="block text-grey-darker text-sm font-bold mb-2"
                    for="email"
                >
                    Email Address
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                    type="email"
                    id="email"
                    required
                    v-model="form.email"
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
                    required
                    v-model="form.password"
                />
                <!-- <p class="text-red text-xs italic">Please choose a password.</p> -->
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                    type="submit"
                >
                    Register
                </button>
                <router-link
                    class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                    to="/"
                >
                    Login
                </router-link>
            </div>
            </form>
        </div>
    </div>
</template>

<script>
import {reactive, ref} from 'vue';
import axios from 'axios';
import {useRouter} from "vue-router";

export default {
    setup() {
        const errors = ref();
        let router = useRouter();
        const form = reactive({
            name: '',
            email: '',
            password: '',
        })
        const handleSubmit = async(evt) => {
            evt.preventDefault()
            try {
                const result = await axios.post('/api/auth/register', form);
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token)
                    await router.push('home')
                }
            }catch (e) {
                if(e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors)
                }
            }
        }
        return {
            form,
            errors,
            handleSubmit,
        }
    }
}
</script>
