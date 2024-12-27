const axios = require('axios');

const Axios = axios.create({
  baseURL: 'http://localhost:8080/api',
  headers: {
    Accept: 'application/json'
  }
});

module.exports = Axios;