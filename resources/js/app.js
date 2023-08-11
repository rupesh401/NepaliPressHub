require('./bootstrap');

window.Vue = require('vue');
import iView from 'iview';
import store from './store'
import router from './router'
import common from './common'
import VueMeta from 'vue-meta';
import Editor from 'vue-editor-js';
import 'iview/dist/styles/iview.css';
import jsonToHtml from './jsonToHtml';
import locale from 'iview/dist/locale/en-US';


Vue.mixin(common)
Vue.mixin(jsonToHtml)
Vue.use(Editor)
Vue.use(iView, { locale }, VueMeta);

Vue.component('mainapps', require('./components/mainapps.vue').default);

const app = new Vue ({
    el: '#app',
    router, store
})