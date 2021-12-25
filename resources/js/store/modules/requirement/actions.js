import RequirementRepository from "../../../abstraction/repository/RequirementRepository";
import {store} from "../../index";

let repository = new RequirementRepository();

export default {
    async loadRequirementList({commit, state}) {
        try {
            commit("SET_LOADING", true);
            const requirement = await repository.index(
                {
                    pagination: state.pagination,
                }
            );
            commit("SET_REQUIREMENT", requirement.data);
            commit("SET_REQUIREMENT_PAGINATION", requirement.pagination);
            return requirement;
        } catch (e) {
            return e;
        } finally {
            commit("SET_LOADING", false);
        }
    },
    async showRequirement({commit}, id) {
        try {
            commit("SET_LOADING", false);
            const requirement = await repository.show(id);
            commit("SET_LOADING", true);
            return requirement;
        } catch (e) {
            return e;
        }
    },
    async storeRequirement({commit}, {data}) {
        try {
            const requirement = await repository.store(data);
            commit("ADD_REQUIREMENT", requirement);
            return requirement;
        } catch (e) {
            store.commit('snackbar/SET_SNACKBAR_STATUS', {value: true})
            store.commit('snackbar/SET_SNACKBAR_MESSAGE', {value: e})
            return e;
        }
    },
    async updateRequirement({commit}, {data}) {
        try {
            const requirement = await repository.update(data);
            commit("UPDATE_REQUIREMENT", requirement);
            return requirement;
        } catch (e) {
            return e;
        }
    },
    async removeRequirement({commit}, requirementId) {
        try {
            const response = await repository.destroy(requirementId);
            commit("REMOVE_REQUIREMENT", requirementId);
            store.commit('snackbar/SET_SNACKBAR_STATUS', {value: true})
            store.commit('snackbar/SET_SNACKBAR_MESSAGE', {value: response.data})
            return response;
        } catch (e) {
            return e;
        }
    },
};
