<template>
    <div>
        <v-form @submit.prevent="loginRequest">
            <v-container style="background: antiquewhite; margin-top: 20px; width: 50%">
                <v-row style="margin: 0 auto">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-text-field
                            v-model="username"
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
                            v-model="password"
                            type="password"
                            label="رمز عبور"
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
                            ورود
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row style="text-align: center">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <router-link to="register">
                            <v-btn type="submit" elevation="2" block>
                                ثبت نام
                            </v-btn>
                        </router-link>
                    </v-col>
                </v-row>
                <v-row style="text-align: center">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <router-link to="/">
                            <v-btn type="submit" elevation="2" block>
                                صفحه اصلی
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

export default {
    name: 'Login',
    components: {
        Notification,
    },
    data: () => ({
        error: null,
        username: "",
        password: "",
    }),
    methods: {
        ...mapActions("user", ['login']),
        async loginRequest() {
            const body = {
                phoneNumber: this.username,
                password: this.password,
            };
            let response = await this.login(body);

            if (!(response instanceof Error)) {
                await this.$router.replace("/");
            }
        },
    }
}
</script>
