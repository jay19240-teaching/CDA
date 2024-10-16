const axios = require('axios');

const Axios = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    Accept: 'application/json'
  }
});

module.exports = Axios;