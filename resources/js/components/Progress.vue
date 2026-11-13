<script setup>
    import { toDoStore } from "@/store/ToDoStore";

    const store = toDoStore();
    const { progress } = store;
</script>

<template>
    <div class="progress">
        <div>{{Math.round(store.progress())}}%</div>
        <span class="progress-bar">
            <span class="completion" :style="`width: ${store.progress()}%`"></span>
        </span>
        <div>{{ store.countActive() }} remaining tasks</div>
    </div>
</template>

<style scoped>
    .progress {
        padding: 0 0.5rem;
        text-align: center;
        margin:1rem;
        font-size: 0.9em;

        .progress-bar {
            display: block;
            width: 100%;
            background-color: #ccc;
            margin: 0.5em;
            border-radius: 9999px;
        }

        .completion {
            display: block;
            padding: 3px;
            background-color: rgb(53, 53, 170);
            border-radius: 9999px;
            transition: all 0.3s ease-in;
        }
    }
</style>