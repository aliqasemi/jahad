import Vue from 'vue'
import Vuex from 'vuex'

import actions from './actions'
import getters from './getters'
import mutations from './mutations'
import state from './state'
import user from './modules/user/index'
import category from './modules/category/index'
import service from './modules/service/index'
import requirement from './modules/requirement/index'

Vue.use(Vuex)

export const store = new Vuex.Store({
    actions,
    getters,
    mutations,
    state,
    modules: {
        user,
        category,
        service,
        requirement
    }
})
