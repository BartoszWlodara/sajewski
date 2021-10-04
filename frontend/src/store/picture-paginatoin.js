import * as actionTypes from './action-types';
import * as getterTypes from './getter-types';
import * as mutationTypes from './mutation';
import API from '../http'

const picture_pagination = {
  state:{
    currentPage: 1,
    totalPages: null,
    buttonNextActive: true,
    buttonPrevActive: false

  },
  mutations:{
    [mutationTypes.SET_PICTURE_NEXT_PAGE](state){
      state.currentPage += 1
    },
    [mutationTypes.SET_PICTURE_PREV_PAGE](state){
      state.currentPage -= 1
    },
    [mutationTypes.SET_PICTURE_NEXT_BUTTON_ACTIVE](state, value){
      state.buttonNextActive = value;
    },
    [mutationTypes.SET_PICTURE_PREV_BUTTON_ACTIVE](state, value){
      state.buttonPrevActive = value;
    },
    [mutationTypes.SET_PICTURE_TOTAL_PAGES](state, number){
      state.totalPages = number;
    },
    [mutationTypes.SET_FIRST_PAGE](state){
      state.currentPage = 1;
    }
  },
  getters:{
    [getterTypes.GET_IMAGE_PAGE_NO](state){
      return state.currentPage
    },
    [getterTypes.GET_IMAGE_NEXT_BUTTON_ACTIVE](state){
      return state.buttonNextActive;
    }
  },
  actions:{
    [actionTypes.PICTURE_NEXT_PAGE]({commit}, category){
      
      let categoryID = category.category;
      let pageNo = category.page;

      let nextPage = pageNo + 1;

      return new Promise((resolve, reject) => {

        API.get(`pictures/picture_get.php?category=${categoryID}&page=${nextPage}`)
        .then(response => {


            commit(mutationTypes.SET_PICTURE_NEXT_PAGE);
          
          
          resolve(response.data.data.Pictures);
        }).catch(error => {

          reject(error);
        })
       
      })
    },
    [actionTypes.PICTURE_PREV_PAGE]({commit}, category){
      
   //   if(category.page > 1){
     //   commit(mutationTypes.SET_PICTURE_PREV_PAGE);
      //}

      let categoryID = category.category;
      let pageNo = category.page;

      let previousPage = pageNo - 1;

      if(previousPage >= 1){
        return new Promise((resolve, reject) => {

          API.get(`pictures/picture_get.php?category=${categoryID}&page=${previousPage}`)
          .then(response => {
  
              commit(mutationTypes.SET_PICTURE_PREV_PAGE);
  
            resolve(response.data.data.Pictures);
          }).catch(error => {
  
            reject(error);
          })
         
        })
      }else{
        return new Promise((resolve, reject) => {

          API.get(`pictures/picture_get.php?category=${categoryID}&page=1`)
          .then(response => {

            resolve(response.data.data.Pictures);
          }).catch(error => {
  
            reject(error);
          })
         
        })
      }
  
    }
  }
}

export default picture_pagination;
