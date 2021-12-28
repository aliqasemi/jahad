export default {
    SET_CATEGORY(state, category) {
        Vue.set(state, "category", category);
    },
    UPDATE_CATEGORY(state, category) {
        const index = state.category.findIndex(
            (x) => x.id === category.id
        );
        Vue.set(state.category, index, category);
        Vue.set(
            state,
            "category",
            state.category
        );
    },

    REMOVE_CATEGORY(state, id) {
        const Index = state.category.findIndex((x) => x.id === id);
        Vue.delete(state.category, Index);
        Vue.set(
            state,
            "category",
            state.category
        );
    },

    ADD_CATEGORY(state, category) {
        Vue.set(
            state.category,
            state.category.length,
            category
        );
        Vue.set(
            state,
            "category",
            state.category
        );
    },

    SET_LOADING(state, value) {
        state.loading = value;
    },
}

