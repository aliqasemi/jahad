<template>
    <div class="text-center">
        <v-snackbar
            v-model="snackbarStatus"
            :timeout="timeout"

        >
            <p v-html="getSnackbarMessage"/>
            <template v-slot:action="{ attrs }">
                <v-btn
                    color="blue"
                    text
                    v-bind="attrs"
                    @click="snackbarStatus = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>

<script>
import {mapGetters, mapMutations} from "vuex";

export default {
    name: "SnackBar",
    data: () => ({
        snackbar: false,
        text: 'My timeout is set to 2000.',
        timeout: 2000,
    }),
    computed: {
        ...mapGetters('snackbar', ['getSnackbarStatus', 'getSnackbarMessage']),
        snackbarStatus: {
            get() {
                return this.getSnackbarStatus;
            },
            set(value) {
                this.SET_SNACKBAR_STATUS({value: value})
            },
        }
    },
    methods: {
        ...mapMutations('snackbar', ['SET_SNACKBAR_STATUS'])
    }
}
</script>

<style scoped>

</style>
