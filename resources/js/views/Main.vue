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
                        <router-link :to="{name:item.routeName}" style="text-decoration: none;color:black;padding: 5px"
                                     class="bredRoute">
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
        <v-row v-if="getLoginStatus" style="padding: 20px">
            <v-col lg="12">
                <router-link :to="{name:'ListServices'}" style="text-decoration: none;color: black">
                    <div class="flex-justified-space-between title-big">
                        <div class="justified-right">
                            <div class="texts">
                                <div class="desc"> جهت مشاهده لیست خدمات و اضافه کردن خدمت درخواستی کلیک کنید</div>
                                <div :class="`Fa Bold text-gradient title-fa`"> خدمت ها</div>
                            </div>
                        </div>
                        <div class="title-en En Bold">
                            <div class="text"> services</div>
                        </div>
                    </div>
                </router-link>
            </v-col>
            <v-col lg="12">
                <router-link :to="{name:'ListRequirements'}" style="text-decoration: none;color: black">
                    <div class="flex-justified-space-between title-big">
                        <div class="justified-right">
                            <div class="texts">
                                <div class="desc"> جهت مشاهده لیست نیازمندی ها و اضافه کردن نیازمندی درخواستی کلیک کنید
                                </div>
                                <div :class="`Fa Bold text-gradient title-fa`"> نیازمندی ها</div>
                            </div>
                        </div>
                        <div class="title-en">
                            <div>Requirement</div>
                        </div>
                    </div>
                </router-link>
            </v-col>
            <v-col lg="12">
                <router-link :to="{name:'ListCategories'}" style="text-decoration: none;color: black">
                    <div class="flex-justified-space-between title-big">
                        <div class="justified-right">
                            <div class="texts">
                                <div class="desc"> جهت مشاهده دسته بندی و بررسی آن ها کلیک کنید</div>
                                <div :class="`Fa Bold text-gradient title-fa`"> دسته بندی</div>
                            </div>
                        </div>
                        <div class="title-en">
                            <div class="text"> Category</div>
                        </div>
                    </div>
                </router-link>
            </v-col>
        </v-row>
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
.bredRoute:hover {
    background-color: cadetblue;
    color: white;
    border-radius: 10px;
    transition: 1s;
}

.title-big {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f5f5f5;
    margin-bottom: 15px;
    background-color: #b1b1b1;
    border-radius: 10px;
    padding: 10px;
}

.title-big:hover {
    background-color: cadetblue;
    transition: 1s;
    border: inset 10px;
}

.title-big * {
    flex-shrink: 0;
}

.title-big .title-fa {
    font-size: 50px;
}

.title-big .desc {
    font-size: 16px;
    opacity: 0.8;
}

.title-big .title-en {
    position: relative;
    width: 300px;
    height: 160px;
    letter-spacing: 3px;
    font-size: 150px;
    line-height: 160px;
    white-space: nowrap;
    text-transform: uppercase;
    color: white;
    opacity: 0.1;
}

.title-big .title-en .text {
    position: absolute;
    left: 0px;
    bottom: 0px;
}

.back-icon-sm i {
    display: none;
    font-size: 25px;
}
</style>
