<template>
    <div class="container-fluid mt-3 px-4">
        <!-- <ul class="nav border-bottom">
        <span class="nav-link active fs-1">Story</span>
      </ul> -->
        <div v-if="successMessage" class="alert alert-success mt-3">
            {{ successMessage }}
        </div>
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-2">Story</h2>
            </div>
            <div class="card-body">
                <!-- <table class="table table-responsive border-start border-end"> -->
                <table class="table-responsive">

                    <table class="table table-bordered">
                        <thead style="background-color: #F8F9FC">
                            <tr>
                                <th class="fs-5 py-4 px-3 font-weight-light" width="500px">Story Title</th>
                                <th class="fs-5 py-4 font-weight-light" width="500px">Mission Title</th>
                                <th class="fs-5 py-4 font-weight-light" width="500px">User Full Name</th>
                                <th class="fs-5 py-4 font-weight-light text-center" width="300px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="story in stories" :key="story.story_id">
                                <td class="px-3">{{ story.title }}</td>
                                <td>{{ story.mission.title }}</td>
                                <td>{{ story.user.first_name + ' ' + story.user.last_name }}</td>
                                <td>
                                    <span v-if="story.status === 'PUBLISHED'"
                                        class="border px-2 py-1 text-success border-success rounded-pill" >
                                        PUBLISHED
                                    </span>
                                    <a v-else @click="publishStory(story.story_id)" style="text-decoration: none;"
                                        aria-label="correct">
                                        <img alt="correct" src="../../../public/Images/correct-icon.svg"
                                            style="width:25px;height:25px;">
                                    </a>
                                    <span v-if="story.status === 'DECLINED'"
                                        class="border px-2 py-1 text-danger border-danger" style="border-radius: 23px;">
                                        DECLINED
                                    </span>
                                    <a v-else @click="declineStory(story.story_id)" style="text-decoration: none;"
                                        id="application_r_{{$mt->story_id}}">
                                        <img src="../../../public/Images/cancle-icon.svg" style="width:25px;height:25px;"
                                            alt="cancel">
                                    </a><br>
                                    <router-link :to="`/admin/story/${story.story_id}/show`"
                                        class="btn btn-outline-warning rounded-pill mt-3 mb-2">View</router-link>
                                        <button type="button" @click="deleteStory(story.story_id)" class="btn btn-white mt-3 mb-2">
                                        <img src="../../../public/Images/bin.png" style="width: 25px; height:25px"
                                            alt="delete">
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </table>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
export default {
    data() {
        return {
            stories: [],
            successMessage: ''
        };
    },
    async created() {
        this.fetchStories();
    },
    methods: {
        async fetchStories() {
            // Make an API request to retrieve the stories from the backend
            axios.get('/api/admin/stories')
                .then((response) => {
                    this.stories = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getStoryUrl(storyId) {
            return `/admin/story/${storyId}/show`;
        },
        publishStory(storyId) {
            axios.post(`/api/admin/stories/${storyId}/publish`)
                .then((response) => {
                    // Handle success response if needed
                    this.successMessage = response.data.message;
                    this.fetchStories(); // Refresh the list of stories
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        declineStory(storyId) {
            axios.post(`/api/admin/stories/${storyId}/decline`)
                .then((response) => {
                    this.successMessage = response.data.message;
                    // Handle success response if needed
                    this.fetchStories(); // Refresh the list of stories
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        deleteStory(storyId) {
            axios.delete(`/api/admin/stories/${storyId}`)
                .then((response) => {
                    this.successMessage = response.data.message;
                    // Handle success response if needed
                    this.fetchStories(); // Refresh the list of stories
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
</script>
