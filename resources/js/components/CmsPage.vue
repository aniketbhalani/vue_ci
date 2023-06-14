<template>
    <div class="container mt-3 p-4 ">
        <h2 class="text-center mb-3"> Cms Page</h2>
        <table class="table-responsive">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th >id</th>
                <th >title</th>
                <th >text</th>
                <th >slug</th>
                <th>status</th>
                <th >Actions</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="cmspage in cmspages" :key="cmspage.cms_page_id">
                    <td>{{ cmspage.cms_page_id }}</td>
                    <td>{{ cmspage.title }}</td>
                    <td>{{ cmspage.text }}</td>
                    <td>{{ cmspage.slug }}</td>
                    <td>{{ getStatusLabel(cmspage.status)  }}</td>
                    <td>
                      <!-- <div> -->
                        <!-- <router-link :to="`/cmspage/${cmspage.cms_page_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                        <router-link :to="`/cmspage/${cmspage.cms_page_id}/edit`" class="btn btn-outline-warning rounded-pill mt-3 px-4">Edit</router-link>&nbsp;&nbsp;
                        <button @click="deleteCmsPage(cmspage.cms_page_id)" type="button" class="btn btn-outline-danger rounded-pill mt-3 px-3 ">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </table>
    </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      cmspages: []
    }
  },
  async created() {
    try {
      const response = await axios.get('/api/cmspage');
      this.cmspages = response.data;
    } catch (error) {
      console.error(error.response.data);
    }
  },
  methods: {
    getStatusLabel(status) {
    return status === '1' ? 'Active' : 'Inactive';
  },
    async deleteCmsPage(cms_page_id) {
      try {
        await axios.delete(`/api/cmspage/${cms_page_id}`);
        this.cmspages = this.cmspages.filter(cmspage => cmspage.cms_page_id !== cms_page_id);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
