
import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import App from './App.vue'
import Permissions from './mixins/Permission.js'
import BootstrapVue from 'bootstrap-vue'
import VueSweetalert2 from 'vue-sweetalert2'
Vue.mixin(Permissions)
Vue.use(VueSweetalert2)
Vue.use(BootstrapVue)

import 'bootstrap-vue/dist/bootstrap-vue.css'
import { mapActions, mapGetters, mapState } from 'vuex'
new Vue({
    el: '#dw',
    router,
    store,
    components: {
        App
    },
    computed: {
        ...mapGetters(['isAuth'])
    },
    methods: {
        ...mapActions('user', ['getUserLogin'])
    },
    created() {
        if (this.isAuth) {
            this.getUserLogin() //REQUEST DATA YANG SEDANG LOGIN
        }
    }

})
