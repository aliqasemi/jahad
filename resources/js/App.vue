<template>
    <v-app style="background: linear-gradient(30deg, cadetblue, #b1b1b1);">
        <navigation v-if="getLoginStatus"/>
        <v-main style="color: black">
            <router-view></router-view>
        </v-main>
        <snack-bar/>
    </v-app>
</template>

<script>
import {setAuthToken} from "./service/AuthService";
import Navigation from "./components/Navigation";
import {mapGetters, mapMutations} from "vuex";
import axios from "axios";
import SnackBar from "./components/GeneralComponent/SnackBar";

export default {
    name: 'App',
    components: {SnackBar, Navigation},
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
<style>
@font-face {
    font-family: "Iransans";
    src: local("Iransans"), url("../fonts/Sans a4fran3.woff") format("woff");
}

* {
    font-family: "Iransans";
}
</style>
