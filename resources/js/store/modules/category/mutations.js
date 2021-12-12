import {addIndexTreeToList} from "../../../service/ProcessTreeArray";

export default {
    SET_CATEGORY(state, category) {
        Vue.set(state, "category", addIndexTreeToList(category));
    },
    UPDATE_CATEGORY(state, category) {
        const index = state.category.findIndex(
            (x) => x.id === category.id
        );
        Vue.set(state.category, index, category);
        Vue.set(
            state,
            "category",
            addIndexTreeToList(state.category)
        );
    },

    REMOVE_CATEGORY(state, id) {
        const Index = state.category.findIndex((x) => x.id === id);
        Vue.delete(state.category, Index);
        Vue.set(
            state,
            "course_category",
            addIndexTreeToList(state.category)
        );
    },

    ADD_CATEGORY(state, courseCategory) {
        Vue.set(
            state.category,
            state.category.length,
            courseCategory
        );
        Vue.set(
            state,
            "category",
            addIndexTreeToList(state.category)
        );
    },

    SET_LOADING(state, value) {
        state.loading = value;
    },
}

