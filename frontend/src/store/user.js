import * as actionTypes from './action-types';
import * as getterTypes from './getter-types';
import * as mutationTypes from './mutation';
import API from '../http.js'
import axios from 'axios'

const user = {
  state:{
    token: localStorage.getItem('user-token') || '',
    status: '',
    userData: ''
  },
  mutations:{
    [mutationTypes.SET_AUTH_REQUEST](state){
      state.status = 'loading'
    },
    [mutationTypes.SET_AUTH_SUCCESS](state, token){
      state.status = 'logged'
      state.token = token.data.jwt
      state.userData = token.data
    },
    [mutationTypes.SET_AUTH_SUCCESS_CURRENT_USER](state){
      state.status = 'logged'
    },
    [mutationTypes.SET_AUTH_ERROR](state){
      state.status = 'error'
      state.token = '',
      state.userData = ''
    },
    [mutationTypes.SET_AUTH_LOGOUT](state){
      state.status = "logout"
      state. token = ''
      state. userData = ''
    }
  },
  getters:{
    [getterTypes.GET_IS_AUTHENTICATED](state){
      return state.token
    },
    [getterTypes.GET_AUTH_STATUS](state){
      return state.status
    },
    [getterTypes.GET_ROLE](state){
      return state.userData
    }
  },
  actions:{
    [actionTypes.AUTH_REQUEST]({commit}, {email, password, captcha}){
      return new Promise((resolve, reject) => {
        commit(mutationTypes.SET_AUTH_REQUEST);
      
        API.post('login.php', {
          email: email,
          password: password,
          recaptcha: captcha
        }).then(response => {
          const token = response.data.jwt;
          
          localStorage.setItem('user-token', token);

          //axios.defaults.headers.common['Authorization'] = token;
          //axios.defaults.headers.common['Access-Control-Allow-Origin'] = true;

          if(response.data.status === 200){
            commit(mutationTypes.SET_AUTH_SUCCESS, response);
          }else{
            commit(mutationTypes.SET_AUTH_ERROR, response);
          }
          resolve(response);
        }).catch(error => {

          commit(mutationTypes.SET_AUTH_ERROR, error);
          localStorage.removeItem('user-token');
          reject(error);
        })
      })
    },
    [actionTypes.AUTH_LOGOUT]({commit}){
      return new Promise((resolve) => {

        commit(mutationTypes.SET_AUTH_LOGOUT);
        localStorage.removeItem('user-token')
        delete axios.defaults.headers.common['Authorization']
        resolve()
      })
    },
    [actionTypes.FETCH_CURRENT_USER]({commit}) {
      
      commit(mutationTypes.SET_AUTH_SUCCESS_CURRENT_USER);

    }
  }
}

export default user;