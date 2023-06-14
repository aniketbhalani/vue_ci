<template>
    <div class="container-fluid">
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <div class="row h-100 w-100">
            <div class="col-md-4 align-self-center" style="padding: 4%;">
                <h4 style="text-align: center;">Forgot Password</h4>
                <p style="text-align: center;">
                    <small>Please enter a new password in the fields below.</small>
                </p>

                <form @submit.prevent="resetPassword">
                    <label for="inputNewPassword" class="col-form-label">New Password</label>
                    <div class="col">
                        <input type="password" class="form-control" v-model="password">
                        <div v-if="errors.password" class="text-danger">{{ errors.password }}</div>
                    </div>

                    <label for="inputConfirmPassword" class="col-form-label">Confirm Password</label>
                    <div class="col">
                        <input type="password" class="form-control" v-model="confirmPassword">
                        <div v-if="errors.confirmPassword" class="text-danger">{{ errors.confirmPassword }}</div>
                    </div>

                    <div v-if="error" class="alert alert-danger m-3">{{ error }}</div>

                    <div class="col">
                        <input type="hidden" name="token" v-model="token">
                    </div>

                    <div class="col">
                        <button type="submit" class="btn btn-outline-warning mt-3" style="width: 100%; border-radius: 23px">
                            Change Password
                        </button>
                    </div>
                </form>

                <p class="m-3 fs-12" style="text-align: center; color:#414141;">
                    <small>Already Registered? <a style="text-decoration:none;" href="#">Login now</a></small>
                </p>

                <p class="m-3" style="text-align: center;">
                    <small><a href="#" style="color:#414141; text-decoration:none;">Privacy Policy</a></small>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            password: '',
            confirmPassword: '',
            token: '', // Set the token value from your URL using Vue Router or other means
            errors: {},
            error: '',
            successMessage: ''
        };
    },
    created() {
        this.token = this.$route.params.token;
    },
    methods: {
        resetPassword() {
            this.errors = {};
            this.error = '';

            //   if (!this.password) {
            //     this.errors.password = 'Please enter a new password.';
            //   }
            //   if (!this.confirmPassword) {
            //     this.errors.confirmPassword = 'Please confirm your new password.';
            //   }
            //   if (this.password !== this.confirmPassword) {
            //     this.errors.confirmPassword = 'Password and confirm password must match.';
            //   }

            if (Object.keys(this.errors).length === 0) {
                axios
                    .post('/api/user/reset-password', {
                        password: this.password,
                        confirm_password: this.confirmPassword,
                        token: this.token,
                    })
                    .then(response => {
                        console.log(response.data.message);
                        this.successMessage = response.data.message;
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            const errors = error.response.data.errors;
                            if (errors.password) {
                                this.errors.password = errors.password[0];
                            }
                            if (errors.confirm_password) {
                                this.errors.confirmPassword = errors.confirm_password[0];
                            }
                        } else {
                            this.error = 'Failed! There is some issue with the server.';
                        }
                    });
            }
        },

    },
};
</script>
