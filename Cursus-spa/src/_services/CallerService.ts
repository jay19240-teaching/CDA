import axios from 'axios';

const Axios = axios.create({
  baseURL: import.meta.env.VITE_API_BASE + '/api',
  headers: {
    Accept: 'application/json'
  },
  withCredentials: true,
  withXSRFToken: true,
  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN'
});

Axios.interceptors.response.use(response => response, error => {
  if (!error.response) {
    return Promise.reject(error);
  }

  return Promise.reject(error);
});

export default Axios;