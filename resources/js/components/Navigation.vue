<template>
    <v-layout style="text-align: right;direction: rtl;">
        <v-container class="Header" style="margin: 5px; padding: 5px;">
            <v-icon class="Menu" @click.stop="drawer = !drawer">fa fa-bars</v-icon>
        </v-container>

        <v-navigation-drawer v-model="drawer" app temporary right width="420">
            <v-list class="pa-1">
                <v-row style="text-align: end;" class="ma-0">
                    <v-col lg="9" class="flex-justified-right">
                        <div class="Title" style="text-align: right">
                            <div class="Name Fa">{{authUser.firstname + ' ' +  authUser.lastname}}</div>
                            <div class="Role Fa">مدیریت</div>
                        </div>
                    </v-col>
                    <v-col lg="3" class="flex-justified-left">
                        <a class="LogOut">
                            <v-tooltip bottom color="black" transition="slide-x-transition">
                                <template v-slot:activator="{ on }">
                                    <v-btn small @click.native.stop="logoutRequest" slot="activator" outlined fab
                                           color="black"
                                           dark v-on="on">
                                        <v-icon dark>fa fa-power-off</v-icon>
                                    </v-btn>
                                </template>
                                <span>خروج از حساب کاربری</span>
                            </v-tooltip>
                        </a>
                    </v-col>
                </v-row>
            </v-list>
        </v-navigation-drawer>
    </v-layout>
</template>
<script>

import {mapActions} from "vuex";

export default {
    name: "Navigation",
    data() {
        return {
            fav: true,
            menu: true,
            message: false,
            hints: true,
            drawer: false,
            user: {name: ""},
            Items: [],
        }
    },
    computed: {
        authUser() {
            return JSON.parse(localStorage.getItem('user'))
        }
    },
    methods: {
        ...mapActions("user",['logout']),
        async logoutRequest() {
            let response = await this.logout();

            if (!(response instanceof Error)) {
                await this.$router.replace("/login");
            }
        }
    }
};

</script>
<style>
.Header .Menu {
    position: absolute;
    right: 20px;
    top: 20px;
}
</style>
