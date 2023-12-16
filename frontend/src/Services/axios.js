import axios from 'axios'
import BaseUrl from "../Composable/baseUrl";

const axiosInstance = axios.create({
    baseURL: BaseUrl,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
    },
})

const token = localStorage.getItem('token');

if(token) {
    axiosInstance.defaults.headers.common['Authorization'] = "Bearer " + token;
}

axiosInstance.interceptors.request.use(function (config) {
    const token = localStorage.getItem('token')
    
    if(token && !config.headers.Authorization) {
        config.headers['Authorization'] = "Bearer " + token
    }

    let outdatedToken = config.headers.Authorization;

    if(!outdatedToken) {
        return config;
    }

    outdatedToken = outdatedToken.split(" ")

    if(token && outdatedToken[1] !== token) {
        config.headers['Authorization'] = "Bearer " + token
    }

   
    return config;

  }, error => Promise.reject(error));

axiosInstance.interceptors.response.use( response => response, function (error) {
    const token = localStorage.getItem('token');
    if(error.response.status == 401 && !token) {
        localStorage.removeItem('user')
        window.location.href = '/'
    }
   
    return Promise.reject(error);
  })


export default axiosInstance;