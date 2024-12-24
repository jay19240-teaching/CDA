import axios from 'axios';
import * as AccountService from '@/_services/AccountService';
import router from '@/router';

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
    console.log('erreur generale');
    return Promise.reject(error);
  }

  if (error.response.status == 401) {
    console.log('erreur d\'authorisation');
    AccountService.logout();
    router.push('/login');
  }
  else {
    console.log('erreur autres');
    return Promise.reject(error);
  }
});

export default Axios;