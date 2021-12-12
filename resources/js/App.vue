<template>
    <v-app>
        <navigation v-if="getLoginStatus"/>
        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
import {setAuthToken} from "./service/AuthService";
import Navigation from "./components/Navigation";
import {mapGetters, mapMutations} from "vuex";

export default {
    name: 'App',
    components: {Navigation},
    data: () => ({
        //
    }),
    computed: {
        ...mapGetters("user", ['getLoginStatus'])
    },
    methods: {
        ...mapMutations("user", ['SET_LOGIN_STATUS'])
    },
    created() {
        const token = localStorage.getItem("token");
        setAuthToken(token);
        this.SET_LOGIN_STATUS(!!token);
    },
};
</script>
