<template>
    <div class="w-6/12 p-10 mx-auto">
        <h1 class="text-2xl"> Todo </h1>
        <input type="text" class="p-2 w-64 border rounded-md" v-model="todo" placeholder="Enter your todo"/>
        <button class="bg-blue-600 text-white px-5 py-2 rounded-md ml-2 hover:bg-blue-400" @click="addTodo">Add</button>
        <ul class="border-t mt-3 cursor-pointer">
           <li :class="`py-3 border-b text-gray-600 ${val.completed ? 'line-through' : ''}`" v-for="(val, idx) in todos" :key="idx" @click="checked(idx)">
            <input type="checkbox" :checked="val.completed" @click="checked(idx)" /> {{val.title}} 
            </li>
        </ul>
    </div>
</template>
<script>
import {ref} from 'vue'
export default {
    setup() {
        const todo = ref('')
        const todos = ref([])
        const addTodo = () => {
            if(todo.value == "") {
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

        return {
            todo, 
            todos,
            checked,
            addTodo,
        }   
    },
}
</script>
