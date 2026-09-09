<script setup>
    import { ref, watch } from "vue";
    import TodoListIem from "./TodoListItem.vue";
    import { toDoStore } from "@/store/ToDoStore";
    import Loader from "./Loader.vue"
    
    const store = toDoStore();
    const nbrItems = ref(0);
    const API_VERSION = 'v1';
    const fetchTodos = async() => {
        store.isReady = false;
        
        try {
            fetch(`${import.meta.env.VITE_API_URL}/${API_VERSION}/tasks`)
            .then(data => data.json())
            .then(data => {
                store.tasks = data.data;
                nbrItems.value = data.length;
                store.isReady = true;
            })
        } catch (e) {
            errorMessage = e.message;
        } finally {
            store.isReady = false;
        }
    }
    fetchTodos();

</script>

<template>
    <span v-if="!store.isReady">
        <Loader />
    </span>
    <span>
        <span v-if="store.isReady && store.tasks.length === 0">
            Vous n'avez aucune tâche pour l'instant.
        </span>
        <div v-else v-for="item in store.tasks" :key="item.id">
            <TodoListIem 
            :id="item.id"
            :title="item.title"
            :isCompleted="item.isCompleted"
        />
        </div>
    </span>
</template>

<style scoped>
    
</style>