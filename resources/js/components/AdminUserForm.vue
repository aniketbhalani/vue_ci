<template>
    <div class="container-fluid mt-4">
      <ul class="nav border-bottom">
        <span class="nav-link active fs-1">User</span>
      </ul>

      <table class="table table-responsive border-start border-end">
        <thead style="background-color: #F8F9FC">
          <tr>
            <th class="fs-5 py-4 px-3 font-weight-light" width="600px">First Name</th>
            <th class="fs-5 py-4 font-weight-light" width="600px">Last Name</th>
            <th class="fs-5 py-4 font-weight-light" width="600px">Email</th>
            <th class="fs-5 py-4 font-weight-light" width="600px">Employee Id</th>
            <th class="fs-5 py-4 font-weight-light" width="600px">Department</th>
            <th class="fs-5 py-4 font-weight-light" width="600px">Status</th>
            <th class="fs-5 py-4 font-weight-light text-end pe-4" width="600px">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.user_id">
            <td class="px-3">{{ user.first_name }}</td>
            <td>{{ user.last_name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.employee_id }}</td>
            <td>{{ user.department }}</td>
            <td>
              <div :style="{ color: user.status ? '#14C506' : 'red' }">
                {{ user.status ? 'Active' : 'Inactive' }}
              </div>
            </td>
            <td>
              <div class="d-flex justify-content-end">
                <a
                  :href="`{{ route('user.edit', '') }}/${user.user_id}`"
                  aria-label="edit"
                  class="btn btn-white"
                >
                  <i class="fas fa-edit" style="color: #F88634"></i>
                </a>

                <!-- <button
                  type="button"
                  :data-target="`#deleteModal-${user.user_id}`"
                  class="btn btn-white"
                  data-toggle="modal"
                >
                  <img src="Images/bin.png" style="width: 16px; height: 20px" alt="delete" />
                </button> -->
                <button @click="deleteUser(user.user_id)" type="button" class="p-2 col border btn btn-danger">Delete</button>

              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  import  axios  from 'axios';
  export default {
    data() {
      return {
        users: [],
      };
    },
    // mounted() {
    //   this.fetchUsers();
    // },


    async created() {
        axios
          .get('/api/admin/users') // Replace with your actual API endpoint
          .then(response => {
            this.users = response.data;
          })
          .catch(error => {
            console.log(error);
          });
    },
    methods: {
    async deleteUser(user_id) {
      try {
        await axios.delete(`/api/admin/users/${user_id}`);
        this.users = this.users.filter(user => user.user_id !== user_id);
      } catch (error) {
        console.error(error);
      }
    }
  }
  };
  </script>

  <style scoped>
  /* Add any necessary styles here */
  </style>
