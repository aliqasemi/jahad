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
                        <div>
                            <div>
                                <div class="desc"> جهت مشاهده لیست خدمات و اضافه کردن خدمت درخواستی کلیک کنید</div>
                                <div class="title-fa"> خدمت ها</div>
                            </div>
                        </div>
                        <div class="title-en En Bold">
                            <div style="position: absolute;text-align: left"> services</div>
                        </div>
                    </div>
                </router-link>
            </v-col>
            <v-col lg="12">
                <router-link :to="{name:'ListRequirements'}" style="text-decoration: none;color: black">
                    <div class="flex-justified-space-between title-big">
                        <div>
                            <div class="texts">
                                <div class="desc"> جهت مشاهده لیست نیازمندی ها و اضافه کردن نیازمندی درخواستی کلیک کنید
                                </div>
                                <div class="title-fa"> نیازمندی ها</div>
                            </div>
                        </div>
                        <div class="title-en">
                            <div style="position: absolute;text-align: left">Requirement</div>
                        </div>
                    </div>
                </router-link>
            </v-col>
            <v-col lg="12">
                <router-link :to="{name:'ListCategories'}" style="text-decoration: none;color: black">
                    <div class="flex-justified-space-between title-big">
                        <div>
                            <div>
                                <div class="desc"> جهت مشاهده دسته بندی و بررسی آن ها کلیک کنید</div>
                                <div class="title-fa"> دسته بندی</div>
                            </div>
                        </div>
                        <div class="title-en">
                            <div style="position: absolute;text-align: left"> Category</div>
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

<style scoped type="scss">
.bredRoute:hover {
    background-color: cadetblue;
    color: white;
    border-radius: 10px;
    transition: 1s;
}

.title-big {
    border: 5px solid transparent;
    background: #AED6D1;
    color: #55706D;
    border-radius: 40px;
    padding: 15px 30px;
    overflow: hidden;
    width: 80%;
    transition: all 1.2s,
    border 0.5s 1.2s,
    box-shadow 0.3s 1.5s;
    white-space: nowrap;
    text-indent: 23px;
    font-weight: bold;
}

.title-big:hover {
    text-indent: 0;
    background: #55706D;
    color: #FFE8A3;
    width: 100%;
    border: 10px solid #8DCCC4;
    box-shadow: 3px 3px 2px rgba(black, 0.15);
}

.title-big:hover .desc {
    color: white;
    transition: 0.5s;
    transform: translateX(0);
    opacity: 1;
}

.title-big * {
    flex-shrink: 0;
}

.title-big .title-fa {
    font-size: 50px;
}

.title-big .desc {
    display: inline-block;
    transform: translateX(300px);
    font-weight: normal;
    opacity: 0;
    transition: opacity 0.1s 0.5s,
    transform 0.4s 0.5s;
}

.title-big .title-en {
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
