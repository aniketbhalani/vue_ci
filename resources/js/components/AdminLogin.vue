<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>

            <div class="card-body">
              <form @submit.prevent="login">
                <div class="form-floating mb-3">
                  <input class="form-control" v-model="email" id="inputEmail" type="email" autocomplete="email" />
                  <label for="inputEmail" class="text-primary">Email address</label>
                  <div class="text-danger" v-if="errors.email">{{ errors.email }}</div>
                </div>

                <div class="form-floating mb-3">
                  <input class="form-control" v-model="password" id="inputPassword" type="password" autocomplete="on" />
                  <label for="inputPassword" class="text-primary">Password</label>
                  <div class="text-danger" v-if="errors.password">{{ errors.password }}</div>
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                  <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                </div>

                <div class="d-flex align-items-center mt-4 mb-0">
                  <button type="submit" class="btn btn-success">Login</button>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                  <a class="small" href="#" @click.prevent="forgotPassword">Forgot Password?</a>
                </div>
              </form>
            </div>

            <div v-if="status" :class="statusClass">
              {{ status }}
            </div>
          </div>
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
        status: '',
        statusClass: '',
      };
    },
    methods: {
      login() {
        // Perform frontend validation
        this.errors = {};

        // Only proceed with backend login if there are no frontend validation errors
        if (Object.keys(this.errors).length === 0) {
          axios
            .post('/api/admin/login', {
              email: this.email,
              password: this.password,
            })
            .then(response => {
              // Handle successful login response
              this.status = response.data.message;
              this.statusClass = 'alert alert-success';
            })
            .catch(error => {
              // Handle login error response
              if (error.response && error.response.data && error.response.data.errors) {
                this.errors = error.response.data.errors;
              } else {
                this.status = 'An error occurred. Please try again.';
                this.statusClass = 'alert alert-danger';
              }
            });
        }
      },
      forgotPassword() {
        // Perform logic for forgot password
        // This method can be implemented separately using Vue.js and Axios to make the necessary API call
      },
    },
  };
  </script>
