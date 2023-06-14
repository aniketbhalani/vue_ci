<template>
    <div id="layoutAuthentication">
      <div id="layoutAuthentication_content">
        <main>
          <div class="container">
            <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
            <div class="row justify-content-center">
              <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                  <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">New Password</h3>
                  </div>
                  <div class="card-body">
                    <div class="small mb-3 text-muted text-center">
                      Enter your new password.
                    </div>
                    <form @submit.prevent="changePassword">
                      <div class="form-floating mb-3">
                        <input
                          class="form-control"
                          id="inputPassword"
                          type="password"
                          name="password"
                          placeholder="Password"
                          v-model="password"
                        />
                        <label for="inputPassword">New Password</label>
                        <div v-if="errors.password" class="text-danger">
                          {{ errors.password[0] }}
                        </div>
                      </div>
                      <div class="form-floating mb-3">
                        <input
                          class="form-control"
                          id="inputConfirmPassword"
                          type="password"
                          name="confirm-password"
                          placeholder="Password"
                          v-model="confirmPassword"
                        />
                        <label for="inputConfirmPassword">Confirm New Password</label>
                        <div v-if="errors['confirm_password']" class="text-danger">
                          {{ errors['confirm_password'][0] }}
                        </div>
                      </div>
                      <div v-if="errorMessage" class="alert alert-danger m-3">
                        {{ errorMessage }}
                      </div>
                      <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="#">Return to login</a>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
      <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
          <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
              <div class="text-muted">© Your Website 2022</div>
              <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
              </div>
            </div>
          </div>
        </footer>
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
        token: '',
        errors: {},
        errorMessage: '',
        successMessage: ''
      };
    },
    created() {
        this.token = this.$route.params.token;
    },
    methods: {
      changePassword() {
        this.errors = {};
        this.errorMessage = '';

        axios
          .post('/api/admin/reset-password', {
            password: this.password,
            'confirm_password': this.confirmPassword,
            token: this.token,
          })
          .then(response => {
            this.successMessage = response.data.message;
            // Reset the form inputs
            this.password = '';
            this.confirmPassword = '';
          })
          .catch(error => {
            if (error.response && error.response.data.errors) {
            this.errors = error.response.data.errors;
          } else if (error.response && error.response.data.error) {
            this.errorMessage = error.response.data.error;
          }
          });
      }
    }
  };
  </script>
