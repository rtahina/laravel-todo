<script setup>
    import { defineAsyncComponent } from 'vue'
    import { useAuthStore } from '@/store/auth'
    import ToDoForm from "./ToDoForm.vue";
    import rocket from '@/images/rocket.svg';
    import shield from '@/images/shield.png';

    const auth = useAuthStore()
    
    const ToDoList = defineAsyncComponent(() =>
        import('./ToDoList.vue')
    );
</script>

<template>
    <div class="todo">
        <div class="app-title">
            <img :src="shield" alt="Rocket" width="auto" height="40px" />
            <h2>Dynamic Todo App</h2>
            <img :src="rocket" alt="Rocket" height="40px" width="auto" />
        </div>
        <header>
            <span>Hello, {{ auth.user.name }} - </span>
            <button @click="auth.logout()">Log out</button>
        </header>
        <ToDoForm/>
        <div class="todo-list-wrapper">
            <ToDoList />
        </div>
    </div>
</template>

<style scoped>
    .todo {
        position: relative;
        width: min(90%, 768px);
        margin: 0 auto;
        padding: 0.5em 2.5rem 2.5rem;
        border: 1px solid #ccc;
        border-radius: 1em;
        background: linear-gradient(to bottom, #efefef, #e5e5e5); 

        .app-title {
            display: flex;
            gap: 0.5em;
            justify-content: flex-start;
            align-items: center;
        }

        header {
            display: flex;
            justify-content: flex-end;
            gap: 0.5em;
            color: #555;

            button {
                border-radius: 9999px;
                border: 1px solid #ccc;
                padding: 0.2em 0.5em;
                background-color: #ddd;
            }
        }
    }
    h2 {
        font-size: 2rem;
        font-weight: 600;
        text-align: left;
    }
    .todo-list-wrapper {
        display: block;
    }
</style>