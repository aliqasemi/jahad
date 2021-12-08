<template>
    <div>
        <v-form v-model="valid" @submit.prevent="loginRequest">
            <v-container style="background: antiquewhite; margin-top: 20px; width: 50%">
                <v-row style="margin: 0 auto">
                    <v-col style="margin: 0 auto"
                           cols="12"
                           md="4"
                    >
                        <v-text-field
                            v-model="username"
                            :rules="emailRules"
                            label="E-mail"
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
                            :rules="passwordRules"
                            type="password"
                            label="Password"
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
            </v-container>
        </v-form>
    </div>
</template>
<script>

import {setAuthToken} from "../service/AuthService";
import {mapActions} from "vuex";

export default {
    name: 'Login',
    components: {
        Notification,
    },
    data: () => ({
        valid: false,
        passwordRules: [
            v => !!v || 'Password is required',
            v => v.length <= 16 || 'Name must be less than 10 characters',
        ],
        email: '',
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        error: null,
        username: "",
        password: "",
    }),
    methods: {
        ...mapActions(['login']),
        async loginRequest() {
            const body = {
                phoneNumber: this.username,
                password: this.password,
            };
            let response = await this.login(body);

            if (!(response instanceof Error)) {
                await this.$router.replace("/home");
            }
        },
    }
}
</script>
