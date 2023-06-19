<template>
    <div>
        <!-- <h2 v-if="isNewCms" class=" mt-5 text-center">Create Cms Page</h2>
        <h2 v-else class=" mt-5 text-center">Edit Cms Page</h2> -->
        <div class="container-fluid mt-3 px-4">
            <div class="card">
                <div class="card-header">
                    <h2 v-if="isNewCms" class="text-center">Create Cms Page</h2>
                    <h2 v-else class=" text-center">Edit Cms Page</h2>
                </div>
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title :</label>
                            <input class="form-control" type="text" id="name" v-model="cmspage.title" required />
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description :</label>
                            <textarea class="form-control" id="description" v-model="cmspage.text" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug :</label>
                            <input class="form-control" type="text" id="slug" v-model="cmspage.slug" required />
                        </div>
                        <div>
                            <label for="status">Status :</label>
                            <select class="form-control" v-model="cmspage.status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" v-if="isNewCms"
                                class="btn btn-outline-warning rounded-pill mt-3 px-4 float-end">Add</button>
                            <router-link to="/cmspage" v-if="isNewCms"
                                class="btn btn-outline-secondary rounded-pill mt-3 px-3">Cancel</router-link>

                            <button type="submit" v-else
                                class="btn btn-outline-warning rounded-pill mt-3 px-3 float-end">Update</button>
                        </div>
                    </form>
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
            cmspage: {
                title: '',
                text: '',
                slug: '',
                description: '',
                status: '1',
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
