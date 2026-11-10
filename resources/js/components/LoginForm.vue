<script setup>
    import { ref } from 'vue'
    import { useAuthStore } from '../store/auth'

    const auth = useAuthStore()

    const form = ref({ email: '', password: '' })
    const error = ref('')
    const loading = ref(false)

    async function submit() {
        error.value = ''
        loading.value = true
        try {
            await auth.login(form.value)
        } catch (e) {
            error.value = e.response?.data?.message || 'Login failed'
        } finally {
            loading.value = false
        }
    }
</script>

<template>
  <form class="login" @submit.prevent="submit">
    <h1>Sign in</h1>
    <input v-model="form.email" type="email" placeholder="Email" required />
    <input v-model="form.password" type="password" placeholder="Password" required />
    <p v-if="error" class="error">{{ error }}</p>
    <button :disabled="loading">{{ loading ? 'Signing in…' : 'Sign in' }}</button>
  </form>
</template>

<style scoped>
    /* todo row */
    .login {
        color: red;
    }
</style>