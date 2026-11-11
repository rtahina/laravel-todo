<script setup>
    import { ref } from 'vue'
    import { useAuthStore } from '@/store/auth'
    import { toDoStore } from "@/store/ToDoStore";
    import Error from "./Error.vue";

    const auth = useAuthStore()
    const store = toDoStore();
    store.errorMessage = '';
    const form = ref({ email: '', password: '' })
    const loading = ref(false)

    async function submit() {
        loading.value = true
        store.errorMessage = ''
        try {
            await auth.login(form.value)
        } catch (e) {
            store.errorMessage = e.response?.data?.message || 'Login failed'
        } finally {
            loading.value = false
        }
    }
</script>

<template>
  <form class="login" @submit.prevent="submit">
    <h1>Sign in</h1>
    <Error 
        :message="store.errorMessage"
    />
    <div class="wrapper">
        <input v-model="form.email" type="email" placeholder="Email" required />
        <input v-model="form.password" type="password" placeholder="Password" required />
        <button :disabled="loading">{{ loading ? 'Signing in…' : 'Sign in' }}</button>
    </div>
  </form>
</template>

<style scoped>
    .login {
        position: relative;
        width: min(90%, 768px);
        margin: 0 auto;
        padding: 0.5em 2.5rem 2.5rem;
        border: 1px solid #ccc;
        border-radius: 1em;
        background: linear-gradient(to bottom, #efefef, #e5e5e5);

        .wrapper {
            display: flex;
            gap: 1em;
        }

        input[type="email"], 
        input[type="password"], 
        button {
            border-radius: 9999px;
            border: 1px solid #ccc;
            color: #555;
            font-size: 1.2em;
            padding: 0.2em 0.5em;
        }
        button {
            flex: 1;
            border: 1px solid rgb(13, 179, 13);
            background: rgb(13, 179, 13);
            color: #fff;
        }
    }
</style>