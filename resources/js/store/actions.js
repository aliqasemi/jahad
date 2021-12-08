import AuthenticationRepository from "../abstraction/repository/AuthenticationRepository";

let repository = new AuthenticationRepository();

export default {
    async login({commit}, body) {
        try {
            commit("SET_LOADING", true);
            const response = await repository.logIn(body);
            console.log("response", response)
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
};
