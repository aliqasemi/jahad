import Vue from "vue";

export default {
    SET_SERVICE(state, service) {
        Vue.set(state, "service", service);
    },
    UPDATE_SERVICE(state, service) {
        const index = state.service.findIndex(
            (x) => x.id === service.id
        );
        Vue.set(state.service, index, service);
    },

    REMOVE_SERVICE(state, id) {
        const Index = state.service.findIndex((x) => x.id === id);
        Vue.delete(state.service, Index);
    },

    ADD_SERVICE(state, service) {
        Vue.set(
            state.service,
            state.service.length,
            service
        );
    },

    SET_LOADING(state, value) {
        state.loading = value;
    },

    SET_SERVICE_PAGINATION(state, value) {
        state.pagination = value;
    }
}

