<template>
    <v-app>
       <navigation />
        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
import {setAuthToken} from "./service/AuthService";
import Navigation from "./components/Navigation";

export default {
    name: 'App',
    components: {Navigation},
    data: () => ({
        //
    }),
    mounted() {
        const token = localStorage.getItem("token");
        setAuthToken(token);
    },
};
</script>
