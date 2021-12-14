<template>
    <v-dialog
        v-model="state"
        persistent
        max-width="290"
    >
        <v-card>
            <br>
            <v-card-text style="direction: rtl">
                آیا از حذف کردن ایتم خود اطمینان دارید?
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="green darken-1"
                    text
                    @click="state = false"
                >
                    خیر
                </v-btn>
                <v-btn
                    color="green darken-1"
                    text
                    @click="$emit('action')"
                >
                    بله
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "deleteModal",
    props: {
        value: {
            type: Boolean,
        },
    },
    computed: {
        state: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit("input", value);
            },
        },
    },
}
</script>

<style scoped>

</style>
