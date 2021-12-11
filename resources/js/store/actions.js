import AuthenticationRepository from "../abstraction/repository/AuthenticationRepository";

let repository = new AuthenticationRepository();

export default {
    async login({commit}, body) {
        try {
            commit("SET_LOADING", true);
            const response = await repository.logIn(body);
            if (!(response instanceof Error)) {
                commit("SET_LOGIN_STATUS", true);
            }
            return response;
        } catch (e) {
            return e;
        } finally {
            commit("SET_LOADING", false);
        }
    },

    async logout({commit}) {
        try {
            commit("SET_LOADING", true);
            const response = await repository.logOut();
            if (!(response instanceof Error)) {
                commit("SET_LOGIN_STATUS", false);
            }
            return response;
        } catch (e) {
            return e;
        } finally {
            commit("SET_LOADING", false);
        }
    },

    async register({commit}, {formData}) {
        try {
            commit("SET_LOADING", true);
            const response = await repository.register(formData);
        } catch (e) {
            return e;
        } finally {
            commit("SET_LOADING", false);
        }
    }
};
