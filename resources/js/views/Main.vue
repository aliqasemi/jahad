<template>
    <div>
        <v-card
            elevation="2"
            outlined
            style="text-align: center; width: 50%;margin: 10px auto"
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
export default {
    name: "Main"
}
</script>

<style scoped>

</style>
