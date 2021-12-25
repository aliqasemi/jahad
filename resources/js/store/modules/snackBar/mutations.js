import Vue from "vue";

export default {
    SET_SNACKBAR_STATUS(state, {value}) {
        Vue.set(state, 'snackbarStatus', value)
    },
    SET_SNACKBAR_MESSAGE(state, {value}) {
        if (value instanceof Object) {
            const values = Object.values(value);
            let messages = '';
            values.forEach((e) => {
                messages += e[0] + '<br>'
            })
            Vue.set(state, 'snackbarMessage', messages);
        } else {
            Vue.set(state, 'snackbarMessage', value);
        }
    },
}
