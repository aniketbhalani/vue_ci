<template>
    <div id="layoutAuthentication">
      <div id="layoutAuthentication_content">
        <main>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                  <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                  </div>
                  <div class="card-body">
                    <div class="small mb-3 text-muted">
                      Enter your email address and we will send you a link to reset your password.
                    </div>
                    <form @submit.prevent="resetPassword" method="post">
                      <div class="form-floating mb-3">
                        <input class="form-control" v-model="email" id="inputEmail" type="email" placeholder="name@example.com" required/>
                        <label for="inputEmail">Email address</label>
                      </div>
                      <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="#">Return to login</a>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                      </div>
                    </form>
                  </div>
                  <div v-if="errorMessage" class="card-footer text-center py-3">
                    <div class="small text-danger">{{ errorMessage }}</div>
                  </div>
                  <div v-if="successMessage" class="card-footer text-center py-3">
                    <div class="small text-success">{{ successMessage }}</div>
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
              <div class="text-muted">Copyright &copy; Your Website 2022</div>
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
  import  axios  from 'axios';
  export default {
    data() {
      return {
        email: '',
        errorMessage: '',
        successMessage: ''
      };
    },
    methods: {
      resetPassword() {
        axios.post('/api/admin/check-email', { email: this.email })
          .then(response => {
            this.successMessage = response.data.message;
            this.errorMessage = '';
          })
          .catch(error => {
            this.errorMessage = error.response.data.message;
            this.successMessage = '';
          });
      }
    }
  };
  </script>
