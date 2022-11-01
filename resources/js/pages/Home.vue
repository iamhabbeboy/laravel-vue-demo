<template>
    <div class="w-6/12 p-10 mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl"> Todo </h1>
            <span class="capitalize">Welcome {{ user && user.name }}, <button
                class="text-orange-500 underline hover:no-underline rounded-md"
                @click="handleLogout">Logout</button></span>
        </div>
        <input type="text" class="p-2 w-64 border rounded-md" v-model="todo" placeholder="Enter your todo"/>
        <button class="bg-blue-600 text-white px-5 py-2 rounded-md ml-2 hover:bg-blue-400" @click="addTodo">Add</button>
        <Loader v-if="isLoading"/>
        <ul class="border-t mt-3 cursor-pointer">
            <li :class="`py-3 border-b text-gray-600 ${val.has_completed ? 'line-through' : ''}`"
                v-for="(val, idx) in todos" :key="idx">
                <input type="checkbox" :checked="val.has_completed" @click="checked(idx)"/>
                <span @click="checked(val, idx)" class="pl-3">{{ val.title }} </span>
                <button class="float-right bg-red-400 px-2 text-white font-bold rounded-md hover:bg-red-600"
                        @click="deleteTodo(val, idx)">&times;
                </button>
            </li>
        </ul>
    </div>
</template>
<script>
import {ref, onMounted} from 'vue'
import {useRouter} from "vue-router";
import {request} from '../helper'
import Loader from '../components/Loader.vue';

export default {
    components: {
        Loader,
    },
    setup() {
        const todo = ref('')
        const todos = ref([])
        const user = ref()
        const isLoading = ref()

        let router = useRouter();
        onMounted(() => {
            authentication()
            handleTodos()
        });

        const authentication = async () => {
            isLoading.value = true
            try {
                const req = await request('get', '/api/user')
                user.value = req.data
            } catch (e) {
                await router.push('/')
            }
        }

        const handleTodos = async () => {
            try {
                const req = await request('get', '/api/todos')
                todos.value = req.data.data
            } catch (e) {
                await router.push('/')
            }
            isLoading.value = false
        }

        const handleNewTodo = async (title) => {
            try {
                const data = {title: title}
                const req = await request('post', '/api/todos', data)
                if (req.data.message) {
                    isLoading.value = false
                    return alert(req.data.message)
                }
                todos.value.push(req.data.data)
            } catch (e) {
                await router.push('/')
            }
            isLoading.value = false
        }

        const handleLogout = () => {
            localStorage.removeItem('APP_DEMO_USER_TOKEN')
            router.push('/')
        }

        const addTodo = () => {
            if (todo.value === "") {
                return alert("Todo cannot be empty");
            }
            isLoading.value = true
            handleNewTodo(todo.value)
            todo.value = ""
        }

        const checked = async (val, index) => {
            try {
                const data = {has_completed: !val.has_completed}
                const req = await request('put', `/api/todos/${val.id}`, data)
                if (req.data.message) {
                    isLoading.value = false
                    return alert(req.data.message)
                }
                todos.value[index].has_completed = !val.has_completed
            } catch (e) {
                await router.push('/')
            }
            isLoading.value = false
        }

        const deleteTodo = async (val, index) => {
            if (window.confirm("Are you sure")) {
                try {
                    const req = await request('delete', `/api/todos/${val.id}`)
                    if (req.data.message) {
                        isLoading.value = false
                        todos.value.splice(index, 1)
                    }
                } catch (e) {
                    await router.push('/')
                }
                isLoading.value = false
            }
        }

        return {
            todo,
            todos,
            user,
            checked,
            addTodo,
            isLoading,
            deleteTodo,
            handleLogout,
        }
    },
}
</script>
