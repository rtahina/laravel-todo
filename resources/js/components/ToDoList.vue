<script setup>
    import { ref } from "vue";
    import TodoListIem from "./TodoListItem.vue";
    import { toDoStore } from "@/store/ToDoStore";
    import Loader from "./Loader.vue"
    import api from '@/api'
    
    const store = toDoStore();
    const API_VERSION = 'v1';
    const fetchTodos = async() => {
        store.isReady = false;
        const url = `/${API_VERSION}/tasks`;
        try {
            const { data } = await api.get(url)
            store.tasks = data.data;
            store.nbrItems = data.length;
            store.isReady = true;
        } catch (e) {
            if (e.response?.data?.status === false) {
                store.errorMessage = e.response.data.message ?? 'Validation failed.'
            } else {
                store.errorMessage = 'Something went wrong. Please try again.'
            }
            store.isReady = true;
        } finally {
            store.isReady = true;
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