import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'font-awesome/css/font-awesome.min.css'

Vue.use(Vuetify)

const opts = {
    icons: {
        iconfont: 'fa4',
    },
}

export default new Vuetify(opts)
