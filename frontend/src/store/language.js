import * as actionTypes from './action-types';
import * as getterTypes from './getter-types';
import * as mutationTypes from './mutation';


/*
const user = {
  state:{
    userData: null,
    //token: localStorage.getItem('user-token') || '',
    //status: ''
    userLoading: false
  },
  mutations:{
    [mutationTypes.SET_CURRENT_USER](state, userData){
      state.userData = userData;
    },
    [mutationTypes.SET_CURRENT_USER_LOADING](state, isLoading){
      state.userLoading = isLoading;
    }
  },
  getters:{
    [getterTypes.GET_CURRENT_USER](state){
      return state.userdata;
    },
    [getterTypes.GET_CURRENT_USER_LOADING](state){
      return state.userLoading;
    }
  },
  actions:{
    [actionTypes.LOGIN]({ commit }, {email, password}){

      commit(mutationTypes.SET_CURRENT_USER_LOADING, true);

      return new Promise((resolve, reject) => {
        API.post('login.php', {
          email: email,
          password: password
        }).then((response) => {
          console.log("vv");
          commit(mutationTypes.SET_CURRENT_USER, response);

          const token = response.data.jwt;
          localStorage.setItem('user-token', token);

          commit(mutationTypes.SET_CURRENT_USER_LOADING, false);

          resolve(response);
      //    axios.defaults.headers.common['Authorization'] = token;

     //     commit(mutationTypes.SET_CURRENT_USER, response);
        }).catch((error)=>{
          commit(mutationTypes.SET_CURRENT_USER_LOADING, false);
          console.log("erere");
          reject(error.response.data.status);
        })
      })
    }
  },
  [actionTypes.LOGOUT]({commit}){
    commit(mutationTypes.SET_CURRENT_USER, null);
    commit(mutationTypes.SET_CURRENT_USER_LOADING, false);

    localStorage.removeItem('user-token');
  },
  [actionTypes.FETCH_CURRENT_USER]({commit, getters}){
    if(getters.GET_CURRENT_USER){
      return Promise.resolve();
    }

    commit(mutationTypes.SET_CURRENT_USER_LOADING, true);

    return API.get('protected.php').then((userdata) =>{
      commit(mutationTypes.SET_CURRENT_USER, userdata);
    }).finally(()=>{
      commit(mutationTypes.SET_CURRENT_USER_LOADING, false);
    })
  }
}
*/



const language = {
  state:{
    language: 'pl'

  },
  mutations:{
    [mutationTypes.SET_LANG](state, lang){
      state.language = lang
    }
  },
  getters:{
    [getterTypes.GET_LANG](state){
      return state.language
    },
  },
  actions:{
    [actionTypes.LANG]({commit}, lang){
      
      return new Promise(() => {
        
          commit(mutationTypes.SET_LANG, lang);
 
      })
    }
  }
}

export default language;
