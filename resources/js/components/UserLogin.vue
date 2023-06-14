<template>
    <div class="container-fluid w-100">
      <div class="row h-100 w-100 justify-content-center">
        <div class="col-md-4 align-self-center" style="padding: 4%;">
          <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

          <form @submit.prevent="submitForm">
            <div class="form-group">
              <label for="email" class="login-text">Email Address</label>
              <input type="email" autocomplete="on" class="form-control m-1" v-model="email" id="email" placeholder="">
              <div v-if="errors.email" class="text-danger">{{ errors.email[0] }}</div>
            </div>

            <div class="form-group">
              <label for="password" class="login-text">Password</label>
              <input type="password" autocomplete="on" class="form-control m-1" v-model="password" id="password" placeholder="">
              <div v-if="errors.password" class="text-danger">{{ errors.password[0] }}</div>
            </div>

            <button type="submit" class="btn btn-outline-warning mt-3" style="width: 100%; border-radius: 23px">Login</button>
          </form>

          <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>

          <p class="m-3" style="text-align: center;">
            <small><a href="#" style="color:#414141; text-decoration:none;">Lost your password?</a></small>
          </p>

          <p class="m-3 fs-12" style="text-align: center; color:#414141;">
            <small>Don't have an account? <a style="text-decoration:none;" href="#">Create an account</a></small>
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
        email: '',
        password: '',
        errors: {},
        errorMessage: '',
        successMessage:''
      };
    },
    methods: {
      submitForm() {
        // Reset previous error messages
        this.errors = {};
        this.errorMessage = '';

        // Perform backend request using Axios
        axios
          .post('/api/user/login', {
            email: this.email,
            password: this.password
          })
          .then(response => {
            // Handle success response
            this.email = '';
            this.password = '';
            this.successMessage = response.data.message;
          })
          .catch(error => {
            // Handle error response
            if (error.response && error.response.data && error.response.data.errors) {
              this.errors = error.response.data.errors;
            } else if (error.response && error.response.data && error.response.data.message) {
              this.errorMessage = error.response.data.message;
            } else {
              this.errorMessage = 'An error occurred. Please try again.';
            }
          });
      }
    }
  };
  </script>
