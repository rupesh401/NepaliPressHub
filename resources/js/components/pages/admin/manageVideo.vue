<template>
    <div>
        <Navbar />

        <Leftbar />

        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 p-r-0 title-margin-right">
                            <div class="page-header p-5">
                                <div class="page-title">
                                    <Button @click="addingModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add New Video
                                    </Button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 p-l-0 title-margin-left">
                            <div class="page-header">
                                <div class="page-title">
                                    <ol class="breadcrumb text-right">
                                        <li>
                                            <router-link to="dashboard">Dashboard</router-link>
                                        </li>
                                        <li class="active">Videos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card alert">
                                    <div class="order-list-item">
                                        <table class="table item-center">
                                            <thead class="content-center">
                                                <tr>
                                                    <th width="5%">ID</th>
                                                    <th width="15%">Picture</th>
                                                    <th width="25%">Title</th>
                                                    <th width="25%">Link</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(video, i) in videos" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>
                                                        <template>
                                                            <img v-if="video.image" class="img-fluid" width="60"
                                                                style="border-radius: 10%"
                                                                :src="`${url_api}uploads/videos/${video.image}`"
                                                                alt="Video Image" />
                                                            <img class="img-fluid" width="60" style="border-radius: 10%"
                                                                v-else src="uploads/videos/default.png" alt="Video Image" />
                                                        </template>
                                                    </td>
                                                    <td> {{ truncate(video.title, 70) }}</td>
                                                    <td>{{ video.link }}</td>
                                                    <td>
                                                        <i-switch @on-change="
                                                            updateStatus(video.id, video.status != 'Published' ? 'Un published' : 'Published'
                                                            )" v-model="video.status" true-value="Published"
                                                            false-value="Un published" true-color="#13ce66"
                                                            false-color="#ff4949" size="small" />
                                                        <Button
                                                            @click="viewVideoModal(i, video.id, video.title, video.link, video.image)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button
                                                            @click=" editVideoModal(i, video.id, video.title, video.link, video.image)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteVideo(video.id, video.title)">
                                                            <Icon type="ios-trash-outline" color="red" size="25" />
                                                        </Button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal v-model="deleteVideoModal" title="Delete Video" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ videoName }}</i> video?</strong></p>
                <p><strong>This action cannot be undone. Once deleted, the video will be permanently removed.</strong></p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteVideo()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateVideoForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewingModal" :title="video.title + ' - Video '" width="40%">
            <template>
                <div class="text-center">
                    <h1>{{ video.title }}</h1>
                    <br>
                    <div class="video-img">
                        <iframe width="400" height="250" :src="`https://www.youtube.com/embed/${video.link}`"
                            frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <br />
                </div>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Close
                </Button>
            </div>
        </Modal>
        <Modal v-model="addingModal" title="Add Video" width="40%">
            <template>
                <Form ref="addFormValidation" :model="video" :rules="ruleValidate">
                    <Row>
                        <Col span="24">
                        <FormItem label="Title" prop="title">
                            <Input v-model="video.title" type="text" placeholder="Know AI better from this video"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <FormItem label="Link" prop="link">
                            <Input v-model="video.link" type="text" placeholder="Youtube Link"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <template>
                            <Upload action="/upload_video_image" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag image here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <Col span="24" v-if="video.image">
                        <img style="object-fit: cover; width: 100%;" :src="`${url_api}uploads/videos/${video.image}`"
                            class="img-fluid" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addNewVideo('addFormValidation')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingModal" title="Edit Video Info" width="40%">
            <template>
                <Form ref="editFormValidation" :model="video" :rules="ruleValidate">
                    <Row>
                        <Col span="24">
                        <FormItem label="Title" prop="title">
                            <Input v-model="video.title" type="text" placeholder="Know AI better from this video"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <FormItem label="Link" prop="link">
                            <Input v-model="video.link" type="text" placeholder="Youtube Link"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <template>
                            <Upload action="/upload_video_image" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag profile picture here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <Col span="24" v-if="video.image">
                        <img style="object-fit: cover; width: 100%;" :src="`${url_api}uploads/videos/${video.image}`"
                            class="img-fluid" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('editFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editVideo('editFormValidation')" type="primary" :disabled="isEditing" :loading="isEditing">
                    <Icon type="md-document" size="18" />
                    {{ isEditing ? "Updating..." : "Update" }}
                </Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import Navbar from "../../inc/navbar";
import Leftbar from "../../inc/leftbar";
import Footer from "../../inc/footer";
export default {
    components: { Navbar, Leftbar, Footer },
    data() {
        return {
            addingModal: false,
            viewingModal: false,
            deleteVideoModal: false,
            isSaving: false,
            deleteImageDetail: "",
            videos: [],
            tableLoading: true,
            keyword: "",
            editingModal: false,
            isEditing: false,
            videoId: "",
            videoName: "",
            rowIndex: "",
            status: "",
            token: "",
            video: { title: "", link: "", image: "" },

            ruleValidate: {
                title: [
                    {
                        required: true,
                        message: "Title field cannot be empty.",
                        trigger: "blur",
                    },
                ],
                link: [
                    {
                        required: true,
                        message: "Link cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            updateRuleValidate: {
                title: [
                    {
                        required: true,
                        message: "Title field cannot be empty.",
                        trigger: "blur",
                    },
                ],
                link: [
                    {
                        required: true,
                        message: "Link cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getVideos();
    },

    methods: {

        async confirmDeleteVideo() {
            this.isSaving = true;
            var data = { id: this.videoId };
            const res = await this.callApi("post", "/delete_video", data);
            if (res.data.status_code === 200) {
                this.getVideos();
                this.deleteVideoModal = false;
                this.isSaving = false;
                this.videoId = "";
                return this.s("Video was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteVideo(id, video) {
            this.deleteVideoModal = true;
            this.videoName = video;
            this.videoId = id;
        },

        truncate(text, length) {
            if (text.length <= length) {
                return text;
            } else {
                return text.slice(0, length) + "...";
            }
        },
        async handleSuccess(response, file) {
            if (this.deleteImageDetail) {
                var path = this.url_api + "uploads/videos/" + this.deleteImageDetail;
                const res = await this.callApi("post", "/delete_images", { path: path });
                if (res.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            this.video.image = response;
        },

        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc: "File format of " + file.name + " is incorrect, Please select jpg or png. ",
            });
        },

        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File " + file.name + " is too large, no more than 2 MB. ",
            });
        },

        async getVideos() {
            const res = await this.callApi("get", "/get_videos");
            if (res.data.status === "success") {
                this.videos = res.data.data;
                this.tableLoading = false;
            } else {
                this.videos = [];
                this.tableLoading = false;
            }
        },

        addNewVideo(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_video", this.video);
                    if (res.data.status_code === 201) {
                        this.getVideos();
                        this.addingModal = false;
                        this.isSaving = false;
                        this.video.image = "";
                        this.$refs[name].resetFields();
                        return this.s("New video was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        viewVideoModal(index, id, title, link, image) {
            this.viewingModal = true;
            this.rowIndex = index;
            this.videoId = id;
            this.video.title = title;
            this.video.link = link;
            if (image) {
                this.video.image = image;
            } else {
                this.video.image = "";
            }
        },
        editVideoModal(index, id, title, link, image) {
            this.editingModal = true;
            this.rowIndex = index;
            this.videoId = id;
            this.video.title = title;
            this.video.link = link;
            if (image) {
                this.video.image = image;
                this.deleteImageDetail = image;
            } else {
                this.video.image = "";
            }
        },

        editVideo(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.videoId, ...this.video };
                    const res = await this.callApi("post", "/edit_video", updatedData);
                    if (res.data.status === "success") {
                        await this.getVideos();
                        this.editingModal = false;
                        this.isEditing = false;
                        this.video.image = ""
                        this.video.link = ""
                        this.video.title = ""
                        this.videoId = ""
                        this.$refs[name].resetFields();
                        return this.s("Video infos wa updated successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        async updateStatus(id, status) {
            const updatedData = { id: id, status: status };
            const res = await this.callApi("post", "/edit_video", updatedData);
            if (res.data.status === "success") {
                await this.getVideos();
            }
        },

        closeModal(name) {
            this.addingModal = false
            this.editingModal = false
            this.viewingModal = false
            this.deleteVideoModal = false
            this.video.image = ""
            this.video.link = ""
            this.video.title = ""
            this.videoId = ""

            // this.$refs[name].resetFields();
        },
    },
};
</script>
