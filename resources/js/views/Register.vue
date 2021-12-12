<template>
    <div>
        <v-form @submit.prevent="registerRequest">
            <v-container style="background: antiquewhite; margin-top: 20px; width: 50%">
                <v-row style="margin: 0 auto">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-text-field
                            v-model="form.firstname"
                            label="نام"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row style="margin: 0 auto">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-text-field
                            v-model="form.lastname"
                            label="نام خانوادگی"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row style="margin: 0 auto">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-text-field
                            v-model="form.phoneNumber"
                            label="شماره تلفن"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row style="margin: 0 auto">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-text-field
                            v-model="form.email"
                            label="ایمیل"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row style="margin: 0 auto">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-text-field
                            v-model="form.password"
                            type="password"
                            label="رمز عبور"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row style="margin: 0 auto">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-text-field
                            v-model="form.password_confirmation"
                            type="password"
                            label="تکرار رمز عبور"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row style="text-align: center">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-btn type="submit" elevation="2" block>
                            ثبت نام
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row style="text-align: center">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <router-link to="/">
                            <v-btn type="submit" elevation="2" block>
                                بازگشت به صفحه اصلی
                            </v-btn>
                        </router-link>
                    </v-col>
                </v-row>
            </v-container>
        </v-form>
    </div>
</template>
<script>
import {mapActions} from "vuex";

var defaultForm = {
    firstname: null,
    lastname: null,
    phoneNumber: null,
    email: null,
    password: null,
    password_confirmation: null,
}

export default {
    name: 'Register',
    components: {
        Notification,
    },
    data: () => ({
        error: null,
        form: defaultForm,
    }),
    methods: {
        ...mapActions("user", ['register']),
        async registerRequest() {
            let response = await this.register({formData: this.form});

            if (!(response instanceof Error)) {
                await this.$router.replace("/");
            }
        },
    }
}
</script>
