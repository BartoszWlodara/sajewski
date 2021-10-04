import * as actionTypes from './action-types';
import * as getterTypes from './getter-types';
import * as mutationTypes from './mutation';

const cookie = {
  state:{
    show_cookies_message: true
  },
  mutations:{
    [mutationTypes.SET_COOKIE_MESSAGE](state, status){
      state.show_cookies_message = status;
    },
  },
  getters:{
    [getterTypes.GET_COOKIES_STATUS](state){
      return state.show_cookies_message
    },
  },
  actions:{
    [actionTypes.COOKIE_MESSAGE]({commit}){
      
      return new Promise(() => {

          commit(mutationTypes.SET_COOKIE_MESSAGE, false);

      });
    },
  }
}

export default cookie;