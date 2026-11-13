import { defineStore } from "pinia";
import { ref } from "vue";

export const toDoStore = defineStore('todos', () => {
    const isLoading = ref(false);
    const isReady = ref(false);
    const errorMessage = ref('');
    const tasks = ref([]);
    const hideActive = ref(false);
    const hideCompleted = ref(false);
    const nbrItems = ref(0);
    
    const todo = ref({
        id:0,
        title: '',
        isCompleted: false
    });

    const addTodo = (todoTitle) => {
        todo.value.title = todoTitle;
        tasks.push(todo)
    }

    const countCompleted = () => {
        const active = tasks.value.filter(item => {
            return item.isCompleted;
        });

        return active.length;
    }

    const countActive = () => {
        const active = tasks.value.filter(item => {
            return item.isCompleted === false;
        });

        return active.length;
    }

    const progress = () => {
        const allTasks = tasks.value.length;
        const completed = countCompleted();

        if (allTasks === 0) return 0;
        
        return (completed * 100) / allTasks;
    }

    const toggleHideActive = () => {
        return hideActive.value = !hideActive.value;
    }

    const toggleHideCompleted = () => {
        return hideCompleted.value = !hideCompleted.value;
    }

    const resetToggles = () => {
        hideCompleted.value = false;
        hideActive.value = false;
    }

    return { 
        addTodo, 
        todo, 
        tasks, 
        countActive, 
        countCompleted, 
        progress, 
        toggleHideActive,
        toggleHideCompleted,
        resetToggles,
        hideActive,
        hideCompleted,
        isLoading, 
        isReady, 
        errorMessage,
        nbrItems
    };
});