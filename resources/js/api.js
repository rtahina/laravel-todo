import axios from 'axios'
import { useAuthStore } from './store/auth'

const api = axios.create({ baseURL: import.meta.env.VITE_API_URL })

api.interceptors.request.use((config) => {
  const auth = useAuthStore()
  if (auth.token) config.headers.Authorization = `Bearer ${auth.token}`
  return config
})

api.interceptors.response.use(
  (res) => res,
  (error) => {
    const isLoginCall = error.config?.url?.endsWith('/login')
    if (error.response?.status === 401 && !isLoginCall) {
      useAuthStore().clear()
    }
    return Promise.reject(error)
  }
)

export default api