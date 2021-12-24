import Vue from "vue";

export default {
    SET_REQUIREMENT(state, requirement) {
        Vue.set(state, "requirement", requirement);
    },
    UPDATE_REQUIREMENT(state, requirement) {
        const index = state.requirement.findIndex(
            (x) => x.id === requirement.id
        );
        Vue.set(state.requirement, index, requirement);
    },

    REMOVE_REQUIREMENT(state, id) {
        const Index = state.requirement.findIndex((x) => x.id === id);
        Vue.delete(state.requirement, Index);
    },

    ADD_REQUIREMENT(state, requirement) {
        Vue.set(
            state.requirement,
            state.requirement.length,
            requirement
        );
    },

    SET_LOADING(state, value) {
        state.loading = value;
    },

    SET_REQUIREMENT_PAGINATION(state, value) {
        state.pagination = value;
    }
}

