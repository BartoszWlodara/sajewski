import * as actionTypes from './action-types';
import * as getterTypes from './getter-types';
import * as mutationTypes from './mutation';
import API from '../http'

const filter = {
  state:{
    filter: {
      CategoryName: "Wszystkie",
      CategoryNameENG: "All",
      CategoryNameIT: "Tutti",
      ID: '00'
    }
  },
  mutations:{
    [mutationTypes.SET_FILTER](state, filter){
      state.filter = filter
    },
    [mutationTypes.SET_FILTER_ALL](state){
      state.filter = {
        CategoryName: "Wszystkie",
        CategoryNameENG: "All",
        CategoryNameIT: "Tutti",
        ID: '00'
      }
    }
  },
  getters:{
    [getterTypes.GET_FILTER](state){
      return state.filter
    },
  },
  actions:{
    [actionTypes.FILTER]({commit}, filter){
      
      return new Promise((resolve, reject) => {
        

        API.get(`pictures/picture_get.php?category=${filter.ID}`)
        .then(response => {

          commit(mutationTypes.SET_FILTER, filter);
          commit(mutationTypes.SET_FIRST_PAGE);
 
          resolve(response.data);
        }).catch(error => {

          reject(error);
        })
       
      })
    },
    [actionTypes.FILTER_ALL]({commit}){
      
      return new Promise((resolve, reject) => {

        API.get(`pictures/picture_get.php`)
        .then(response => {

          commit(mutationTypes.SET_FILTER_ALL);
          commit(mutationTypes.SET_FIRST_PAGE);
 
          resolve(response.data);
        }).catch(error => {

          reject(error);
        })
       
      })
    }
    
  }
}

export default filter;
