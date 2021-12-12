import {convertListToTree} from "../../../service/ProcessTreeArray";

export default {
    getListCategory: (state) => {
        return state.category;
    },
    getCategoryLoading: (state) => state.loading,
    getTreeCategories: (state) => convertListToTree(state.category),
}
