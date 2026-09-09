<script setup>
    import { ref } from 'vue';
    import { toDoStore } from "@/store/ToDoStore";
    import Error from "./Error.vue";
    import Progress from "./Progress.vue"

    const newTodoItem = ref('');
    const store = toDoStore();
    const API_VERSION = 'v1';
    const { errorMessage, isReady, toggleHideActive, toggleHideCompleted, resetToggles } = store;

    const addNewTask = () =>{
        store.errorMessage = '';
        store.isReady = false;
        const url = `${import.meta.env.VITE_API_URL}/${API_VERSION}/tasks/`;
        const patchData = {
            title: newTodoItem.value
        };
        try {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(patchData)
            })
            .then(data => data.json())
            .then(data => {
                if (data.errors) {
                    store.errorMessage = data.message;
                } else {
                    store.tasks.unshift(data.data);
                    newTodoItem.value = '';
                }
                store.isReady = true;
            })
        } catch (e) {
            store.errorMessage = e.message;
        } finally {
            store.isReady = false;
        }
    }

    const toggleShowActive = () => {
        resetToggles();
        toggleHideCompleted();
    }

    const toggleShowCompleted = () => {
        resetToggles();
        toggleHideActive();
    }

    const resetFilters = () => {
        resetToggles();
    }
    
</script>

<template>
     <Error 
        :message="store.errorMessage"
    />
    <div class="app-header">
        <div class="left">
            <form @submit.prevent="">
                <input type="text" v-model="newTodoItem" placeholder="Ajouter une nouvelle tâche" required />
                <button @click="addNewTask"><span>+</span> Ajouter une tâche</button>
            </form>
        </div>
        <div class="right">
            <div class="tags">
                <span @click="resetFilters" :class="{active: !store.hideActive && !store.hideCompleted}">Toutes ({{ store.tasks.length }})</span>
                <span @click="toggleShowActive" :class="{active: store.hideCompleted}">En cours ({{ store.countActive() }}) </span>
                <span @click="toggleShowCompleted" :class="{active: store.hideActive}">complétée{{ store.countCompleted() > 1 ? 's' : '' }} ({{ store.countCompleted() }})</span> 
            </div>
            <Progress />
        </div>
    </div>
</template>

<style scoped>
    .app-header {
        display: flex;
        flex-direction: column;
        width: 100%;

        @media (min-width: 768px) {
            flex-direction: row;
        }

        .left, .right {
            width: 100%;

            @media (min-width: 768px) {
                width: 50%;
            }
        }

        form {
            margin: 1rem auto;
            display: flex;
            flex-direction: column;
            gap: 1em;
        }
        
        input[type="text"] {
            display: block;
            width: 100%;
            border: 2px solid rgb(13, 179, 13);
            border-radius: 9999px;
            padding: 0.5em;
            color: #333;
            font-size: 1.3em;
        }

        button {
            display: inline-flex !important;
            justify-content: center;
            align-items: center;
            gap: 0.5em;
            border: none;
            outline: none;
            box-shadow: none;
            background: rgb(13, 179, 13);
            border-radius: 9999px;
            padding: 0.5em;
            color: #fff;
            font-weight: 600;
            font-size: 1.3em;

            span {
                width: 30px;
                height: 30px;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                border: 3px solid #fff;
                border-radius: 30px;
                font-size: 1.5em;
            }
        }

        .tags {
            display: flex;
            justify-content: flex-start;
            gap: 0.5em;
            padding: 1rem 0.5rem;
            
            span {
                display: inline-flex;
                justify-content: center;
                align-items: center;
                padding: 1em 1em;
                border: 2px solid #ccc;
                border-radius: 9999px;
                color: #555;
                font-size: 0.8em;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease-in;
            }
        }
    }

    .active {
        background-color: #ddd;
    }
</style>