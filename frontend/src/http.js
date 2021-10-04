import axios from "axios";
import globalURL from "./globalURL"
//import * as actionTypes from './store/action-types'
import store from './store';
import router from './router';
//import router from '@ro'

const instance = axios.create({
  baseURL: globalURL,
  headers: {
      "Content-type": "application/json",
      "Cache-Control": "no-cache"
  }
});

instance.interceptors.response.use((response) => {
  return response;
}, (error) => {
  if(error.response.status === 401){
    store.dispatch('AUTH_LOGOUT').then(() => {
        router.push('/paneladministracyjny/login');
    })
  }
  return Promise.reject(error);
});

export default instance;

/*
export default axios.create({
  baseURL: globalURL,
  headers: {
      "Content-type": "application/json"
  }
});*/


/*export default () => {

  const instance = axios.create({
    baseURL: globalURL,
    headers: {
        "Content-type": "application/json"
    }
  });

  instance.interceptors.response.use((response) => {
    if(response.status === 401){
      alert("Unauthorized");
    }

    return response;

  }, (error) => {
    if(error.response && error.response.data){
      return Promise.reject(error.response.data);
    }

    return Promise.reject(error.message);
  })

  return instance;

}*/

