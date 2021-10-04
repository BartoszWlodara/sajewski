import Vue from 'vue'
import Vuex from 'vuex'
import ceratePersistedState from 'vuex-persistedstate'
/*import * as actionTypes from './action-types'
import * as mutationTypes from './mutation'
import axios from 'axios' */
import user from './user'
import filter from './filter'
import language from './language'
import picture_pagination from './picture-paginatoin'
import cookie from './cookie'

Vue.use(Vuex)

export default new Vuex.Store({
  /*
  state: {
    token: localStorage.getItem('user-token') || '',
    status: ''
  },
  mutations: {

    [mutationTypes.SET_AUTH_REQUEST]: (state) => {
      state.status = 'loading'
    },
    [mutationTypes.SET_AUTH_SUCCESS]: (state, token) => {
      state.status = 'success'
      state.token = token
    },
    [mutationTypes.SET_AUTH_ERROR]: (state) => {
      state.status = 'error'
    }

  },
  actions: {

    [actionTypes.AUTH_REQUEST]: ({commit, dispatch}, user) => {
      return new Promise((resolve, reject) => { 
        commit(actionTypes.AUTH_REQUEST)
        axios({url: 'auth', data: user, method: 'POST' })
          .then(resp => {
            const token = resp.data.token
            localStorage.setItem('user-token', token) 
            commit(AUTH_SUCCESS, token)
            // you have your token, now log in your user :)
            dispatch(USER_REQUEST)
            resolve(resp)
          })
        .catch(err => {
          commit(AUTH_ERROR, err)
          localStorage.removeItem('user-token') 
          reject(err)
        })
      })
    },

    [actionTypes.AUTH_LOGOUT]: ({commit, dispatch}) => {
      return new Promise((resolve, reject) => {
        commit(AUTH_LOGOUT)
        localStorage.removeItem('user-token') // clear your user's token from localstorage
        resolve()
      })
    }

  },
  modules: {
  },
  getters:{
    isAuthenticated: state => !!state.token,
    authStatus: state => state.status
  }
  */
  modules:{
    user,
    filter,
    language,
    picture_pagination,
    cookie
  },
  plugins: [ceratePersistedState()]
})
