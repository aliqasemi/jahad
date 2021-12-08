<template>
    <v-row>
        <v-col>
            <router-link to="/home">خانه</router-link>
        </v-col>
        <v-col>
            <button v-if="getLoginStatus" @click="logoutRequest">خروج</button>
            <router-link v-else to="/login">ورود</router-link>
        </v-col>
    </v-row>
</template>
<script>

import {mapActions, mapGetters} from "vuex";

export default {
    name: "Navigation",
    computed: {
        ...mapGetters(['getLoginStatus'])
    },
    methods: {
        ...mapActions(['logout']),
        async logoutRequest() {
            let response = await this.logout();

            if (!(response instanceof Error)) {
                await this.$router.replace("/login");
            }
        }
    }
};

</script>
