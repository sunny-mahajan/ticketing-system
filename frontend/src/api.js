import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api',  // Adjust if needed
  withCredentials: false, // Allow cookies to be sent for authentication
})

// // Ensure CSRF token is fetched before making POST requests
// api.get('/sanctum/csrf-cookie').then(() => {
//   console.log('CSRF token set')
// })

export default api
