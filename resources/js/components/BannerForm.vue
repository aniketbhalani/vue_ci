<template>
    <div>
        <h2 v-if="isNewBanner">Add Banner</h2>
        <h2 v-else>Edit Banner</h2>
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


<!-- // import axios from "axios";
// export default {
//     data() {
//         return {
//             banner: {
//                 text: "",
//                 sort_order: 0,
//                 image: "",
//             },
//         };
//     },
//     computed: {
//         isNewBanner() {
//             return !this.$route.path.includes("edit");
//         },
//     },
//     async created() {
//         if (!this.isNewBanner) {
//             const response = await axios.get(
//                 `/api/banner/${this.$route.params.id}`
//             );
//             console.log(response);
//             this.banner = response.data;
//             console.log(this.banner);
//         }
//     },
//     methods: {
//         handleImageChange(event) {
//             const file = event.target.files[0];
//             console.log(file);
//             if (file) {
//                 const reader = new FileReader();

//                 reader.onload = (e) => {
//                     this.banner.image = e.target.result;
//                 };

//                 reader.readAsDataURL(file);
//             } else {
//                 this.banner.image = null;
//             }
//         },

//         async submitForm() {
//             // try {
//             //     console.log(this.banner); // Add this line to log the banner object
//             //     const config = {
//             //         headers: { "content-type": "multipart/form-data" },
//             //     };

//             //     let formData = new FormData();
//             //     console.log(formData);
//             //     formData.append("file", this.banner.image);
//             //     if (this.isNewBanner) {
//             //         await axios.post("/api/banner", formData, config);
//             //     } else {
//             //         await axios.put(
//             //             `/api/banner/${this.$route.params.id}`,
//             //             this.banner
//             //         );
//             //     }
//             //     this.$router.push("/banner");
//             // } catch (error) {
//             //     console.error(error);
//             // }
//             try {
//     const formData = new FormData();
//     formData.append('text', this.banner.text);
//     formData.append('sort_order', this.banner.sort_order);
//     formData.append('image', this.banner.image);

//     if (this.isNewBanner) {
//       await axios.post('/api/banner', formData, {
//         headers: {
//           'Content-Type': 'multipart/form-data'
//         }
//       });
//     } else {
//       await axios.put(`/api/banner/${this.$route.params.id}`, formData, {
//         headers: {
//           'Content-Type': 'multipart/form-data'
//         }
//       });
//     }
//     this.$router.push('/banner');
//   } catch (error) {
//     console.error(error);
//   }
//         },
//     },
// }; -->


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

