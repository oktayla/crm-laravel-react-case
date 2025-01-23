import axios from 'axios'

const BASE_URL = 'http://api.laravel-app.test/'

export const api = (token) => {
  let headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }

  if (token) headers['Authorization'] = `Bearer ${token}`

  return axios.create({
    baseURL: BASE_URL,
    headers
  });
}
