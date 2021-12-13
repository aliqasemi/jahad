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
import axios from "axios";

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
    async created() {
        const token = localStorage.getItem("token");
        setAuthToken(token);
        try {
            await axios.get('http://127.0.0.1:8000/api/jahad/categories');
            this.SET_LOGIN_STATUS(!!token);
        } catch (e) {
            setAuthToken();
            await this.$router.replace("/login");
        }
    },
};
</script>
