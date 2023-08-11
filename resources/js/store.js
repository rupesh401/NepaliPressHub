import axios from "axios";
import vuex from "vuex";
import Vue from "vue";

Vue.use(vuex);

export default new vuex.Store({
    state: {
        userInfos: [],
    },

    getters: {
        loginData() {
            return state.userInfos;
        },
    },

    mutations: {
        updateUser(state, data) {
            state.userInfos = data;
        },
        updateProfilePicture(state, data) {
            state.userInfos.profile_image = data;
        },
    },

    actions: {},
});
