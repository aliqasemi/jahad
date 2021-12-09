<template>
    <v-app>
        <navigation/>
        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
import {setAuthToken} from "./service/AuthService";
import Navigation from "./components/Navigation";
import {mapMutations} from "vuex";

export default {
    name: 'App',
    components: {Navigation},
    data: () => ({
        //
    }),
    methods: {
        ...mapMutations(['SET_LOGIN_STATUS'])
    },
    mounted() {
        const token = localStorage.getItem("token");
        setAuthToken(token);
        this.SET_LOGIN_STATUS(!!token);
    },
};
</script>
