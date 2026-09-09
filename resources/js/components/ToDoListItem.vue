<script setup>
    import { toDoStore } from "@/store/ToDoStore";
   
    const store = toDoStore();
    const API_VERSION = 'v1';
    const props = defineProps({
        id: {
            type: Number,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        isCompleted: {
            type: Boolean,
            default: false
        }
    });

    // Toggle a task is_completed column
    const toggleComplete = (id) => {
        const url = `${import.meta.env.VITE_API_URL}/${API_VERSION}/tasks/${id}`;
        try {
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            })
            .then(data => data.json())
            .then(data => {
                if (data.errors) {
                    store.errorMessage = data.message;
                } else {
                    store.tasks.find((o, i) => {
                        if (o.id === id) {
                            store.tasks[i] = { 
                                id: o.id, 
                                title: o.title, 
                                isCompleted: !o.isCompleted 
                            };
                            return true;
                        }
                    });
                }
            })
        } catch (e) {
            store.errorMessage = e.message;
        } finally {
            store.isReady = true;
        }
    }

    const confirmDeletion = (id) => {
        if (window.confirm("Voulez-vous vraiment supprimer cette tâche?")) {
            deleteTask(id)
        }
    }
    
    const deleteTask = (id) => {
        store.isReady = false;
        const url = `${import.meta.env.VITE_API_URL}/v1/tasks/${id}`;
        try {
            const deletedId = id;
            const data = fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            })
            .then(data => data.json())
            .then(data => {
                if (data.errors) {
                    store.errorMessage = data.message;
                } else {
                    const remainingTasks = store.tasks.filter(item => {
                        return item.id !== deletedId;
                    });
                    store.tasks = remainingTasks;
                }
                store.isReady = true;
            })
        } catch (e) {
            store.errorMessage = e.message;
        } finally {
            store.isReady = false;
        }
    }
</script>

<template>
    <span class="todo-list-item" :class="{hide: (isCompleted && store.hideCompleted) || (!isCompleted && store.hideActive)}">
        <div class="container">
            <div class="round">
                <input type="checkbox" @click="toggleComplete(id)" :checked="isCompleted" :id="`chk_${id}`" />
                <label :for="`chk_${id}`"></label>
            </div>
        </div>
        <span :class="{ completed: isCompleted }" 
            :title="'Click to mark as ' + (isCompleted ? 'todo' : 'completed')">{{ title }}
        </span>
        <button @click="confirmDeletion(id)">Delete</button>
    </span>
</template>

<style scoped>
    /* todo row */
    .todo-list-item {
        display: flex;
        margin-bottom: 0.5rem;
        border: 1px solid #ccc;
        padding: 1rem 1.5rem;
        font-weight: 500;
        background-color: #ddd;
        border-radius: 10px;
        transition: all 0.3s ease-in;

        button {
            border: none;
            outline: none;
            box-shadow: none;
            width: 20px;
            height: 20px;
            background: url(../images/bin.png) center center no-repeat;
            background-size: contain;
            overflow: hidden;
            text-indent: -9999px;
        }
    }
    .todo-list-item:hover {
        background-color: #efefef;
    }
    .todo-list-item {
        span {    
            display: block;
            padding-left: 0.5rem;
            flex: 1;
        }
    }
    
    /* Checkbox */
    .round {
        position: relative;
    }

    .round label {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 50%;
        cursor: pointer;
        height: 20px;
        left: 0;
        position: absolute;
        top: 0;
        width: 20px;
    }

    .round label:after {
        border: 3px solid #fff;
        border-top: none;
        border-right: none;
        content: "";
        height: 5px;
        left: 4px;
        opacity: 0;
        position: absolute;
        top: 5px;
        transform: rotate(-45deg);
        width: 9px;
    }

    .round input[type="checkbox"] {
        visibility: hidden;
    }

    .round input[type="checkbox"]:checked + label {
        background-color: #66bb6a;
        border-color: #66bb6a;
    }

    .round input[type="checkbox"]:checked + label:after {
        opacity: 1;
    }

    /* Utilities */
    .completed {
        font-weight: normal;
        color: #999;
    }

    .hide {
        display: none;
    }
</style>