<template>
    <div>
      <h2 v-if="isNewCms">Add</h2>
      <h2 v-else>Edit cmspage</h2>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label for="title" class="form-label">title</label>
            <input class="form-control" type="text" id="name" v-model="cmspage.title" required />
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" v-model="cmspage.text" required></textarea>
          </div>
          <div class="mb-3">
            <label for="slug" class="form-label">slug:</label>
            <input class="form-control" type="text" id="slug" v-model="cmspage.slug" required />
          </div>
          <div>
            <label for="status">Status:</label>
            <select v-model="cmspage.status" id="status">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <button type="submit" v-if="isNewCms" class="btn btn-primary">Add</button>

          <router-link to="/cmspage" v-if="isNewCms" class="p-2 col border btn btn-success">Cancel</router-link>

          <button type="submit" v-else class="btn btn-primary">Update</button>

        </form>
    </div>
  </template>

  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        cmspage: {
          title: '',
          text:'',
          slug:'',
          description: '',
          status:'1',
        }
      }
    },
    computed: {
      isNewCms() {
        return !this.$route.path.includes('edit');
      }
    },
    async created() {
      if (!this.isNewCms) {
        const response = await axios.get(`/api/cmspage/${this.$route.params.id}`);
        console.log(response);
        this.cmspage = response.data;
        console.log(this.cmspage);
      }

    },
    methods: {
      async submitForm() {
        try {
          if (this.isNewCms) {
            await axios.post('/api/cmspage', this.cmspage);
          } else {
            await axios.put(`/api/cmspage/${this.$route.params.id}`, this.cmspage);
          }
          this.$router.push('/cmspage');
        } catch (error) {
          console.error(error);
        }
      }
    }
  }
  </script>
