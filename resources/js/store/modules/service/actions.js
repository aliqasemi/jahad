import ServiceRepository from "../../../abstraction/repository/ServiceRepository";

let repository = new ServiceRepository();

export default {
    async loadServiceList({commit}) {
        try {
            commit("SET_LOADING", true);
            const service = await repository.index();
            commit("SET_SERVICE", service);
            return service;
        } catch (e) {
            return e;
        } finally {
            commit("SET_LOADING", false);
        }
    },
    async showService({commit}, id) {
        try {
            commit("SET_LOADING", false);
            const service = await repository.show(id);
            commit("SET_LOADING", true);
            return service;
        } catch (e) {
            return e;
        }
    },
    async storeService({commit}, {data}) {
        try {
            const service = await repository.store(data);
            commit("ADD_SERVICE", service);
            return service;
        } catch (e) {
            return e;
        }
    },
    async updateService({commit}, {data}) {
        try {
            const service = await repository.update(data);
            commit("UPDATE_SERVICE", service);
            return service;
        } catch (e) {
            return e;
        }
    },
    async removeService({commit}, serviceId) {
        try {
            const response = await repository.destroy(serviceId);
            commit("REMOVE_SERVICE", serviceId);
            return response;
        } catch (e) {
            return e;
        }
    },
};
