<template>
    <div style="width: 90%;margin: 0 auto; direction: rtl">
        <div style="direction: rtl; background-color: aliceblue;border-radius: 10px">
            <v-breadcrumbs :items="items">
                <template v-slot:divider>
                    <v-icon>fa fa-chevron-left</v-icon>
                </template>
                <template v-slot:item="{ item }">
                    <v-breadcrumbs-item
                        :disabled="item.disabled"
                    >
                        <router-link :to="{name:item.routeName}" style="text-decoration: none;color:black;padding: 5px"
                                     class="bredRoute">
                           <span>
                                <v-icon>{{ item.icon }}</v-icon>  {{ item.text.toUpperCase() }}
                           </span>
                        </router-link>
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
        <v-row style="direction: rtl;margin-top: 20px">
            لیست خدمت ها
        </v-row>
        <br>
        <hr style="display: block; width: 75%"/>
        <items/>

        <router-link :to="{name:'AddService'}">
            <v-btn>اضافه کردن حدمت جدید</v-btn>
        </router-link>
    </div>
</template>

<script>
import Items from "../../components/Service/Items";

export default {
    name: "Services",
    data() {
        return {
            items: [
                {
                    text: 'صفحه اصلی',
                    disabled: false,
                    routeName: "Main",
                    icon: "fa fa-home"
                },
                {
                    text: 'خدمت ها',
                    disabled: true,
                    routeName: "ListServices",
                    icon: "fa fa-wrench"
                },
            ]
        }
    },
    components: {Items}
}
</script>

<style scoped>
.bredRoute:hover {
    background-color: cadetblue;
    color: white;
    border-radius: 10px;
    transition: 1s;
}
</style>
