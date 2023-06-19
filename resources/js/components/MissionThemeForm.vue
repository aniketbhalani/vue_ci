<template>
    <div>
        <h2 v-if="isNewMissionTheme" class="mt-5 text-center">
            Create Mission Theme
        </h2>
        <h2 v-else class="mt-5 text-center">Edit Mission Theme</h2>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Title:</label>
                            <input
                                class="form-control"
                                type="text"
                                id="name"
                                v-model="missiontheme.title"
                                required
                            />
                        </div>
                        <div>
                            <label for="status">Status:</label>
                            <select
                                class="form-control"
                                v-model="missiontheme.status"
                                id="status"
                            >
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <!-- <button type="submit" v-if="isNewMissionTheme" class="btn btn-primary">Add</button>
          <button type="submit" v-else class="btn btn-primary">Update</button> -->
                        <div>
                            <div>
                                <button
                                    type="submit"
                                    v-if="isNewMissionTheme"
                                    class="btn btn-outline-warning rounded-pill mt-3 px-4 float-end"
                                >
                                    Add
                                </button>
                                <router-link
                                    to="/missionskill"
                                    v-if="isNewMissionTheme"
                                    class="btn btn-outline-secondary rounded-pill mt-3 px-3"
                                    >Cancel</router-link
                                >

                                <button
                                    type="submit"
                                    v-else
                                    class="btn btn-outline-warning rounded-pill mt-3 px-3 float-end"
                                >
                                    Update
                                </button>
                            </div>
                        </div>
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
            missiontheme: {
                title: "",
                status: 1,
            },
        };
    },
    computed: {
        isNewMissionTheme() {
            return !this.$route.path.includes("edit");
        },
    },
    async created() {
        if (!this.isNewMissionTheme) {
            const response = await axios.get(
                `/api/missiontheme/${this.$route.params.id}`
            );
            console.log(response);
            this.missiontheme = response.data;
            console.log(this.missiontheme);
        }
    },
    methods: {
        async submitForm() {
            try {
                if (this.isNewMissionTheme) {
                    await axios.post("/api/missiontheme", this.missiontheme);
                } else {
                    await axios.put(
                        `/api/missiontheme/${this.$route.params.id}`,
                        this.missiontheme
                    );
                }
                this.$router.push("/missiontheme");
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
