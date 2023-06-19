<template>
    <div class="ms-5 mt-5 me-5">
      <h2>Edit Banner</h2>
      <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
      </div>
      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="description" class="form-label">Banner Description:</label>
          <textarea
            class="form-control"
            type="text"
            id="description"
            v-model="banner.text"
          ></textarea>
          <!-- <div v-if="errors.text">
            <div
              v-for="(error, index) in errors.text"
              :key="index"
              class="text-danger"
            >
              {{ error }}
            </div>
          </div> -->
        </div>

        <div class="mb-3">
          <label for="sortorder" class="form-label">Sort Order:</label>
          <input
            class="form-control"
            type="number"
            id="sortorder"
            v-model="banner.sort_order"
          />
          <!-- <div v-if="errors.sort_order">
            <div
              v-for="(error, index) in errors.sort_order"
              :key="index"
              class="text-danger"
            >
              {{ error }}
            </div>
          </div> -->
        </div>

        <div class="mb-3">
          <label for="photo" class="form-label">Photo:</label>
          <input
            class="form-control"
            type="file"
            id="image"
            @change="handleImageChange"
            accept="image/*"
          />

          <!-- <div v-if="errors.image">
            <div
              v-for="(error, index) in errors.image"
              :key="index"
              class="text-danger"
            >
              {{ error }}
            </div>
          </div> -->
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
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
        errors: {},
        successMessage: "",
      };
    },
    async created() {
      const response = await axios.get(`/api/banner/${this.$route.params.id}`);
      //console.log(response.data.image);
      this.banner.text = response.data.text;
      this.banner.sort_order = response.data.sort_order;
    },
    methods: {
      handleImageChange(event) {
        const file = event.target.files[0];
        console.log(file);
        if (file) {
          this.banner.image = file;
        } else {
          this.banner.image = null;
        }
      },
      async submitForm() {
        try {
          const formData = new FormData();
          formData.append('_method','PUT');
          formData.append("text", this.banner.text);
          formData.append("sort_order", this.banner.sort_order);
          if (this.banner.image) {
            formData.append("image", this.banner.image);
          }

          axios
            .post(`/api/banner/${this.$route.params.id}`, formData, {
              headers: {

                "Content-Type": "multipart/form-data",
              },
            })
            .then((response) => {
              console.log(response.data.message);
              this.successMessage = response.data.message;
            })
            .catch((error) => {
              // Handle error
              if (error.response) {
                this.errors = error.response.data.errors;
              } else {
                // Handle other types of errors
              }
            });
        } catch (error) {
          console.error(error);
        }
      },
    },
  };
  </script>
