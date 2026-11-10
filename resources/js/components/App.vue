<script setup>
  import { onMounted } from 'vue'
  import { useAuthStore } from '../store/auth'
  import LoginForm from './LoginForm.vue'
  import ToDo from "./ToDo.vue";

  const auth = useAuthStore()
  onMounted(() => auth.init())
</script>

<template>
  <div v-if="!auth.ready" class="splash">Loading…</div>
  <ToDo v-else-if="auth.isAuthenticated" />
  <LoginForm v-else />
</template>