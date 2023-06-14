<template>
    <div class="container-fluid ">
      <div class="row h-100 w-100 justify-content-center">
        <div class="col-lg-4 align-self-center" style="padding: 4%;">
          <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>

          <form @submit.prevent="registerUser">
            <label for="inputFirstName" class="col-form-label">First Name</label>
            <div class="col">
              <input type="text" autocomplete="on" class="form-control" v-model="firstName" />
              <div v-if="errors.first_name" class="text-danger">{{ errors.first_name[0] }}</div>
            </div>

            <label for="inputLastName" class="col-form-label">Last Name</label>
            <div class="col">
              <input type="text" autocomplete="on" class="form-control" v-model="lastName" />
              <div v-if="errors.last_name" class="text-danger">{{ errors.last_name[0] }}</div>
            </div>

            <label for="inputPhone" class="col-form-label">Phone Number</label>
            <div class="col">
              <input type="tel" autocomplete="on" class="form-control" v-model="phoneNumber" />
              <div v-if="errors.phone_number" class="text-danger">{{ errors.phone_number[0] }}</div>
            </div>

            <label for="inputEmail" class="col-form-label">Email</label>
            <div class="col">
              <input type="email" autocomplete="on" class="form-control" v-model="email" />
              <div v-if="errors.email" class="text-danger">{{ errors.email[0] }}</div>
            </div>

            <label for="inputPassword" class="col-form-label">Password</label>
            <div class="col">
              <input type="password" autocomplete="on" class="form-control" v-model="password" />
              <div v-if="errors.password" class="text-danger">{{ errors.password[0] }}</div>
            </div>

            <label for="inputConfirmPassword" class="col-form-label">Confirm Password</label>
            <div class="col">
              <input type="password" autocomplete="on" class="form-control" v-model="confirmPassword" />
              <div v-if="errors.confirm_password" class="text-danger">{{ errors.confirm_password[0] }}</div>
            </div>

            <div class="col">
              <button type="submit" class="btn btn-outline-warning mt-3" style="width: 100%; border-radius: 23px">
                Register
              </button>
            </div>
          </form>

          <p class="m-3" style="text-align: center;">
            <small>
              <a href="#" style="color:#414141; text-decoration:none;">Lost your password?</a>
            </small>
          </p>

          <p class="m-3 fs-12" style="text-align: center; color:#414141;">
            <small>
              Already Registered? <a style="text-decoration:none;" href="#">Login now</a>
            </small>
          </p>

          <p class="m-3" style="text-align: center;">
            <small>
              <a href="#" style="color:#414141; text-decoration:none;">Privacy Policy</a>
            </small>
          </p>

          <div v-if="successMessage" class="alert alert-success mt-3">
          {{ successMessage }}
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
        firstName: '',
        lastName: '',
        phoneNumber: '',
        email: '',
        password: '',
        confirmPassword: '',
        errorMessage: '',
        errors: {},
        successMessage: null,
      };
    },
    methods: {
      registerUser() {
        // Perform backend validation and API call using Axios
        axios
          .post('/api/user/register', {
            first_name: this.firstName,
            last_name: this.lastName,
            phone_number: this.phoneNumber,
            email: this.email,
            password: this.password,
            confirm_password: this.confirmPassword,
          })
          .then((response) => {
            // Handle successful registration
            this.successMessage = response.data.message;
            console.log(response.data);
            // Redirect or show success message as needed
          })
          .catch((error) => {
            // Handle registration errors
            if (error.response.status === 422) {
              this.errors = error.response.data.errors;
            } else if (error.response.status === 500) {
              this.errorMessage = error.response.data.message;
            } else {
              this.errorMessage = 'An error occurred. Please try again.';
            }
          });
      },
    },
  };
  </script>
