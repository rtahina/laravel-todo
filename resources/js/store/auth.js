import { defineStore } from 'pinia'
import api from '../api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    ready: false, // false until we've verified any saved token
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
  },
  actions: {
    async init() {
        if (this.token) {
            try {
                await this.fetchUser()
            } catch {
                this.clear()
            }
        }
        this.ready = true
    },
    async login(credentials) {
      const { data } = await api.post('/login', credentials)
      this.token = data.data.token
      localStorage.setItem('token', data.data.token)
      localStorage.setItem('user', JSON.stringify(data.data.user))
      this.user = data.data.user ?? null
    },
    async fetchUser() {
      const user = localStorage.getItem('user') || null
      this.user = JSON.parse(user)
      return JSON.parse(user)
    },
    logout() {
      this.clear()
    },
    clear() {
      this.token = null
      this.user = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    },
  },
})