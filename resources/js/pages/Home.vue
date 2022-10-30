<template>
    <div class="w-6/12 p-10 mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl"> Todo </h1>
            <span class="capitalize">Welcome {{user && user.name}}, <button class="text-orange-500 underline hover:no-underline rounded-md" @click="handleLogout">Logout</button></span>
        </div>
        <input type="text" class="p-2 w-64 border rounded-md" v-model="todo" placeholder="Enter your todo"/>
        <button class="bg-blue-600 text-white px-5 py-2 rounded-md ml-2 hover:bg-blue-400" @click="addTodo">Add</button>
        <ul class="border-t mt-3 cursor-pointer">
            <li :class="`py-3 border-b text-gray-600 ${val.completed ? 'line-through' : ''}`" v-for="(val, idx) in todos" :key="idx" >
                <input type="checkbox" :checked="val.completed" @click="checked(idx)" />
                <span @click="checked(idx)" class="pl-3">{{val.title}} </span>
                <button class="float-right bg-red-400 px-2 text-white font-bold rounded-md hover:bg-red-600" @click="deleteTodo(idx)">&times; </button>
            </li>
        </ul>
        <!-- <Loader /> -->
    </div>
</template>
<script>
import {ref, onMounted} from 'vue'
import axios from 'axios';
import {useRouter} from "vue-router";
// import Loader from '../components/Loader.vue';
export default {
    // components: {
    //     Loader,
    // },
    setup() {
        const todo = ref('')
        const todos = ref([])
        const user = ref()
        let router = useRouter();
        onMounted(() => authentication());
        const authentication = async () => {
            try {
                const token = localStorage.getItem('APP_DEMO_USER_TOKEN')
                if (token !== undefined || token !== "") {
                    const headers = {
                        headers: {
                            Authorization: 'Bearer ' + token
                        }
                    }
                    const response = await axios.get('/api/user', headers)
                    if (response.status === 200) {
                        user.value = response.data
                    }
                }
            }catch (e) {
                await router.push('/')
            }
        }

        const handleLogout = () => {
            localStorage.removeItem('APP_DEMO_USER_TOKEN')
            router.push('/')
        }

        const addTodo = () => {
            if(todo.value === "") {
                return alert("Todo cannot be empty");
            }
            if(todos.value.includes(todo.value)) {
                return alert("Todo already exist")
            }
            todos.value.push({
                title: todo.value,
                completed: false
            })
            todo.value = ""
        }

        const checked = (index) => {
            if(!todos.value[index]) {
                return alert("Error occured")
            }
            todos.value[index].completed = todos.value[index].completed ? false : true
        }

        const deleteTodo = (index) => {
            alert(index)
        }

        return {
            todo,
            todos,
            user,
            checked,
            addTodo,
            deleteTodo,
            handleLogout,
        }
    },
}
</script>
