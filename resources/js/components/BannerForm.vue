<template>
    <div>
        <h2 v-if="isNewBanner" class="text-center mt-3 mb-3">Create Banner Page</h2>
        <h2 v-else class="text-center mt-3 mb-3">Edit Banner Page</h2>
        
        <div class="container">
        <div class="card">
        <div class="card-body">
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="description" class="form-label"
                    >Banner Description:</label
                >
                <textarea
                    class="form-control"
                    type="text"
                    id="name"
                    v-model="banner.text"
                    required
                ></textarea>
            </div>
            <div class="mb-3">
                <label for="sortorder" class="form-label">Sort Order:</label>
                <input
                    class="form-control"
                    type="number"
                    id="sort_order"
                    v-model="banner.sort_order"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo:</label>
                <input
                    class="form-control"
                    type="file"
                    id="photo"
                    @change="handleImageChange"
                    accept="image/*"
                    required
                />
                <img
                    :src="banner.image"
                    v-if="banner.image"
                    alt="Selected Image"
                />
                
            </div>
           
            <button type="submit" v-if="isNewBanner"
                    class="btn btn-outline-warning rounded-pill mt-3 px-4 float-end">Add</button>
                <router-link to="/banner" v-if="isNewBanner"
                    class="btn btn-outline-secondary rounded-pill mt-3 px-3">Cancel</router-link>

                <button type="submit" v-else
                    class="btn btn-outline-warning rounded-pill mt-3 px-3 float-end">Update</button>
        </form>
        </div>
        </div>
        </div>
    </div>
</template>



<script>
import axios from "axios";
export default {
    data() {
        return {
            banner: {
                text: "",
                sort_order: 0,
                image: null,

            },
        };
    },
    computed: {
        isNewBanner() {
            return !this.$route.path.includes("edit");
        },
    },
    async created() {
        if (!this.isNewBanner) {
            const response = await axios.get(`/api/banner/${this.$route.params.id}`);
            console.log(response);
            this.banner = response.data;
            console.log(this.banner);
        }
    },
    methods: {
        handleImageChange(event) {
            const file = event.target.files[0];
            console.log(file);
            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    // this.banner.image = e.target.result;
                    //  this.banner.imagename = file.name;
                    // console.log(this.banner.imagename);
                    console.log(event.target.files[0]);
                this.banner.image = event.target.files[0];
                console.log(this.banner.image);
                };

                reader.readAsDataURL(file);
            } else {
                this.banner.image = null;
            }
        },
        async submitForm() {
            try {
                const formData = new FormData();
                formData.append("text", this.banner.text);
                formData.append("sort_order", this.banner.sort_order);
                formData.append("image",this.banner.image);
                for (const field of formData.entries()) {
      console.log(field[0], field[1],field[2]);
    }



                if (this.isNewBanner) {
                    await axios.post("/api/banner", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    });
                } else {

                    await axios.put(`/api/banner/${this.$route.params.id}`, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    });
                }
                this.$router.push("/banner");
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>

