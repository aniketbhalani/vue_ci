<template>
    <div class="container-fluid px-4 mt-4">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-3">Show Story</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="missionSelect" class="form-label">Mission</label>
                        <input type="text" class="form-control" :disabled="true" v-model="story.mission.title" />
                    </div>
                    <div class="col-md-6">
                        <label for="title" class="form-label">My Story Title</label>
                        <input type="text" class="form-control" :disabled="true" v-model="story.title"
                            placeholder="Enter your title" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 mt-5">
                        <label for="summary-ckeditor" class="form-label">My Story</label>
                        <!-- <textarea :disabled="true" class="story-textarea" id="editor1" v-model="story.description"></textarea> -->
                        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig" :disabled="isEditorDisabled">
                        </ckeditor>
                    </div>
                </div>

                <h4 class="mt-4">Story Media</h4>
                <div>
                    <div class="py-3">
                        <a v-for="(media, index) in videoMedia" :key="index" class="btn border" :href="media.path">
                            video-{{ index }}
                        </a>
                    </div>

                    <div id="preview">
                        <div v-for="(media, index) in imageMedia" :key="index" style="
              position: relative;
              display: inline-block;
              margin-right: 10px;
              margin-left: 10px;
            ">
                            <img :src="`../../../storage/${media.path}`" alt=""
                                style="width:115px;height:115px;padding-right:10px;" />


                        </div>
                    </div>
                </div>

                <div class="row py-4">
                    <div class="col">
                        <a aria-label="cancel" class="btn mx-4 btn-outline-secondary rounded-pill px-3 float-end" @click="goBack">Back</a>
                    </div>
                </div>
            </div>
        </div>
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
            story: {
                mission: {
                    title: '',
                }
            },
            editor: ClassicEditor,
            editorData: "<p>Content of the editor.</p>",
            editorConfig: {
                // The configuration of the editor.
            },
            isEditorDisabled: false,
        };
    },
    computed: {
        videoMedia() {
            return this.story.story_media.filter((media) => media.type === "video");
        },
        imageMedia() {
            return this.story.story_media.filter((media) =>
                ["png", "jpeg", "jpg"].includes(media.type)
            );
        },
    },
    methods: {
        fetchStory(id) {
            // Make an API request to fetch the story data from the Laravel backend
            axios
                .get(`/api/admin/stories/${id}`)
                .then((response) => {
                    this.story = response.data;
                    console.log(this.story);
                    this.editorData = this.story.description;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        goBack() {
            // Navigate back to the stories index page
            this.$router.push("/admin/story");
        },
    },
    async created() {
        const id = this.$route.params.id;
        this.fetchStory(id);
    },
};
</script>
