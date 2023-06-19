<template>
    <div class="ms-5 mt-5 me-5">
      <h2 v-if="isNewBanner">Add Banner</h2>
      <h2 v-else>Edit Banner</h2>
      <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
      </div>
      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="description" class="form-label">Banner Description:</label>
          <!-- <textarea
            class="form-control"
            type="text"
            id="name"
            v-model="banner.text"
          ></textarea> -->
          <ckeditor :editor="editor" v-model="banner.text" :config="editorConfig"
                          :disabled="isEditorDisabled"></ckeditor>
          <div v-if="errors.text">
            <div
              v-for="(error, index) in errors.text"
              :key="index"
              class="text-danger"
            >
              {{ error }}
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="sortorder" class="form-label">Sort Order:</label>
          <input
            class="form-control"
            type="number"
            id="sort_order"
            v-model="banner.sort_order"
          />
        </div>
        <div v-if="errors.sort_order">
          <div
            v-for="(error, index) in errors.sort_order"
            :key="index"
            class="text-danger"
          >
            {{ error }}
          </div>
        </div>
        <div class="mb-3">
          <label for="photo" class="form-label">Photo:</label>
          <input
            class="form-control"
            type="file"
            id="photo"
            @change="handleImageChange"
            accept="image/*"
          />

          <div v-if="errors.image">
            <div
              v-for="(error, index) in errors.image"
              :key="index"
              class="text-danger"
            >
              {{ error }}
            </div>
          </div>
          <!-- <input type="file" @change="handleImageChange" accept="image/*" />
      <img :src="selectedImage" v-if="selectedImage" alt="Selected Image" /> -->
        </div>
        <button type="submit" v-if="isNewBanner" class="btn btn-primary">
          Add Banner
        </button>
        <button type="submit" v-else class="btn btn-primary">Update</button>
      </form>
    </div>
  </template>





  <script>
  import axios from "axios";
  import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
  import CKEditor from "@ckeditor/ckeditor5-vue";
  export default {
      components: {
          // Use the <ckeditor> component in this view.
          ckeditor: CKEditor.component,
      },
    data() {
      return {
          editor: ClassicEditor,

              editorConfig: {
                  // The configuration of the editor.
              },
              isEditorDisabled: false,
        banner: {

          sort_order: 0,
          image: "",
          text: "<p>Content of the editor.</p>",
        },
        errors: {},
        successMessage: "",
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
        //   console.log(this.banner);
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
          formData.append("image", this.banner.image);
          for (const field of formData.entries()) {
            console.log(field[0], field[1], field[2]);
          }

          if (this.isNewBanner) {
            axios
              .post("/api/banner", formData, {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              })
              .then((response) => {
                this.successMessage = response.data.message;
                console.log(response.data.message);
                //   this.$router.push("/banner");
              })
              .catch((error) => {
                if (error.response.status === 422) {
                  this.errors = error.response.data.errors;
                } else {
                  // Handle other types of errors
                }
              });
          } else {
            axios
              .put(`/api/banner/${this.$route.params.id}`, formData, {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              })
              .then((response) => {
                console.log(this.formData);
                console.log(response.data.message);
                this.successMessage = response.data.message;
              })
              .catch((error) => {
                // Handle error
                if (error.response.status === 422) {
                  this.errors = error.response.data.errors;
                } else {
                  // Handle other types of errors
                }
              });
          }
        } catch (error) {
          console.error(error);
        }
      },
    },
  };
  </script>
