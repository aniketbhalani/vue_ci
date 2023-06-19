<template>
    <div class="container-fluid">
      <div class="row h-100 w-100">
        <div class="col-md-4 align-self-center" style="padding: 4%;">
          <h4 style="text-align: center;">Forgot Password</h4>
          <p style="text-align: center;">
            <small>
              Enter your email address you've using for your account below and we will send you a password reset link
            </small>
          </p>
          <form @submit.prevent="resetPassword">
            <div class="form-group">
              <label for="" class="login-text">Email Address</label>
              <input type="email" class="form-control m-1" v-model="email" placeholder="Enter your email address..." />
              <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
            </div>
            <button type="submit" class="btn btn-outline-warning mt-3" style="width: 100%; border-radius: 23px">
              Reset my Password
            </button>
          </form>

          <div v-if="status" class="alert alert-danger">{{ status }}</div>
          <div v-if="success" class="alert alert-success">{{ success }}</div>

          <p class="m-3 fs-12" style="text-align: center; color:#414141;">
            <small>
              Already Registered? <a style="text-decoration:none;" href="/user/login">Login now</a>
            </small>
          </p>

          <p class="m-3" style="text-align: center;">
            <small>
              <a href="/policies" style="color:#414141; text-decoration:none;">Privacy Policy</a>
            </small>
          </p>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        email: "",
        errors: {},
        status: "",
        success: ""
      };
    },
    methods: {
      resetPassword() {
        // Send an AJAX request to the backend route for resetting password
        axios.post("/api/user/check-email", { email: this.email })
          .then(response => {
            // Handle the success response
            this.success = response.data.success;
            this.status = "";
            this.errors = {};
          })
          .catch(error => {
            // Handle the error response
            if (error.response.status === 422) {
              this.errors = error.response.data.errors;
            } else {
              this.errors = {};
              this.status = error.response.data.message;
            }
            this.success = "";
          });
      }
    }
  };
  </script>
