import {convertListToTree} from "../../../service/ProcessTreeArray";

export default {
    getListService: (state) => {
        return state.category;
    },
    getServiceLoading: (state) => state.loading,
}
