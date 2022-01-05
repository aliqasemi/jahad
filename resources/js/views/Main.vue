<template>
    <div style="width: 90%;margin: 0 auto; direction: rtl">
        <div v-if="getLoginStatus" style="direction: rtl; background-color: aliceblue;border-radius: 10px">
            <v-breadcrumbs :items="items">
                <template v-slot:divider>
                    <v-icon>fa fa-chevron-left</v-icon>
                </template>
                <template v-slot:item="{ item }">
                    <v-breadcrumbs-item
                        :disabled="item.disabled"
                    >
                        <router-link :to="{name:item.routeName}" style="text-decoration: none;color:black;padding: 5px" class="bredRoute">
                           <span>
                                <v-icon>fa fa-home</v-icon>  {{ item.text.toUpperCase() }}
                           </span>
                        </router-link>
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
        <v-card
            elevation="2"
            outlined
            style="text-align: center; width: 50%;margin: 10px auto"
            v-else
        >
            <v-card-title style="display: block"> جهاد سازندگی</v-card-title>
            <v-card-subtitle>سامانه جهاد سازدنگی</v-card-subtitle>
            <v-card-actions>
                <router-link to="/login" style="margin: 0 auto">
                    <v-btn outlined
                           rounded
                           text
                    >ورود
                    </v-btn>
                </router-link>
                <router-link to="/register" style="margin: 0 auto">
                    <v-btn
                        outlined
                        rounded
                        text
                    >ثبت نام
                    </v-btn>
                </router-link>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "Main",
    data() {
        return {
            items: [
                {
                    text: 'صفحه اصلی',
                    disabled: false,
                    routeName: "Main",
                    icon: "fa fa-home"
                },
            ],
        }
    },
    computed: {
        ...mapGetters("user", ['getLoginStatus'])
    },
}
</script>

<style scoped>
.bredRoute:hover{
    background-color: cadetblue;
    color: white;
    border-radius: 10px;
    transition: 1s;
}
</style>
