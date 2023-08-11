<template>
    <div>
        <div class="unix-login">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="login-content">
                            <div class="login-logo">
                                <a  href="/" target="_blank"><span>Sports News</span></a>
                            </div>
                            <div class="login-form"  style="border-radius: 30px;">
                                <h4>Administratior Login</h4>
                                <form @submit.prevent="login()">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input v-model="loginData.email" type="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input v-model="loginData.password" type="password" class="form-control" placeholder="Password">
                                    </div>
                                    <button  :loading="isLogging" type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30"> {{ isLogging ? "LOGGING..." : "LOGIN" }}</button>
                                    <div class="register-link m-t-15 text-center">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    metaInfo() {
        return {
            title: "Shadomby | Login",
            meta: [
                {
                    name: "description",
                    content: "Shalom Development Organization | Login",
                },
            ],
        };
    },
    data() {
        return {
            loginData: {
                email: "",
                password: "",
            },
            isLogging: false,
        };
    },

    methods: {
        async login() {
            if (this.loginData.email.trim() == "") return this.w("Email is required");
            if (this.loginData.password.trim() == "") return this.w("Password is required");
            this.isLogging = true;
            const res = await this.callApi("post", "/login_data", this.loginData);
            if (res.data.status === "success") {
                this.isLogging = false;
                this.s("Your authenticated successfully!");
                window.location = "/dashboard";
            } else if (res.data.status == "blocked") {
                this.isLogging = false;
                window.location = "/blocked";
            } else if (res.data.status == "failed") {
                this.isLogging = false;
                return this.e("Wrong email or password write correct and try again.");
            } else {
                this.isLogging = false;
                return this.swr();
            }
        },
    },
};
</script>
