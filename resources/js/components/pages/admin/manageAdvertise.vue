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
                                        Add New Advertese info
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
                                        <li class="active">Advertise With Us </li>
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
                                                    <th width="55%">Content</th>
                                                    <th width="10%">Language</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(adv, i) in advertises" :key="i">
                                                    <td>{{ ++i }}</td>

                                                    <td> {{ truncatedText(adv.content) }}</td>
                                                    <td v-if="adv.lang === 'en'">English</td>
                                                    <td v-else>Nepali</td>
                                                    <td>
                                                        <Button @click="viewVideoModal(adv.id, adv.lang, adv.content)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button @click=" editVideoModal(adv.id, adv.lang, adv.content)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteVideo(adv.id)">
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
                <p><strong>Are you sure you want to delete this advertise informations?</strong></p>
                <p><strong>This action cannot be undone. Once deleted, the informations will be permanently
                        removed.</strong></p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteVideo()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal()" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewingModal" title="Advertise With Us Content" width="40%">
            <template>
                <div class="text-center">
                    <div v-html="advertise.content"></div>
                </div>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Close
                </Button>
            </div>
        </Modal>
        <Modal v-model="addingModal" title="Add Advertise Info" width="40%">
            <template>
                <Form :model="advertise">
                    <Row>
                        <Col span="24">
                        <FormItem label="Language" prop="lang">
                            <Select v-model="advertise.lang" filterable>
                                <Option value="en">English</Option>
                                <Option value="ne">Nepali</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <vue-editor useCustomImageHandler @image-added="handleImageAdded"
                            @image-removed="handleImageRemoved" ref="editors" v-model="advertise.content" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal()" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addNewAdvertiseInfo()" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingModal" title="Edit Video Info" width="40%">
            <template>
                <Form :model="advertise">
                    <Row>
                        <Col span="24">
                        <FormItem label="Language" prop="lang">
                            <Select v-model="advertise.lang" filterable>
                                <Option value="en">English</Option>
                                <Option value="ne">Nepali</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <vue-editor useCustomImageHandler @image-added="handleImageAdded"
                            @image-removed="handleImageRemoved" ref="editors" v-model="advertise.content" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal()" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editVideo()" type="primary" :disabled="isEditing" :loading="isEditing">
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
import { VueEditor } from "vue2-editor";
export default {
    components: { Navbar, Leftbar, Footer, VueEditor },
    data() {
        return {
            addingModal: false,
            viewingModal: false,
            deleteVideoModal: false,
            isSaving: false,
            deleteImageDetail: "",
            advertises: [],
            filteredVideos: [],
            titleFilter: "",
            statusFilter: "",
            tableLoading: true,
            keyword: "",
            editingModal: false,
            isEditing: false,
            advertiseId: "",
            videoName: "",
            rowIndex: "",
            status: "",
            token: "",
            advertise: { lang: "", content: "" },
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getVideos();
    },

    methods: {

        async handleImageRemoved(image) {
            if (this.clearType == false) {
                const url = image;
                const path = url.split("://")[1];
                const subPath = path.split("/").slice(1).join("/");
                const datas = { path: subPath };
                const res = await this.callApi("post", "/delete_images", datas);
                if (res.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            } else {
                console.log("Image should be available in server");
            }
        },
        async handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            var formData = new FormData();
            formData.append("image", file);
            formData.append("path", "uploads/advertise");
            const res = await this.callApi("post", "/uploads_images", formData);
            if (res.data.success == 1) {
                const url = res.data.file.url; // Get  from response
                Editor.insertEmbed(cursorLocation, "image", url);
                resetUploader();
            } else {
                console.log(res);
            }
        },

        async handleSuccess2(res, file) {
            if (this.deleteImageTwo) {
                var path = this.url_api + "uploads/advertise/" + this.deleteImageTwo;
                const response = await this.callApi("post", "/delete_images", { path: path });
                if (response.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            this.about.image2 = res;
        },
        async handleSuccess(res, file) {
            if (this.deleteImageOne) {
                var path = this.url_api + "uploads/advertise/" + this.deleteImageOne;
                const response = await this.callApi("post", "/delete_images", { path: path });
                if (response.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            res;
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

        async confirmDeleteVideo() {
            this.isSaving = true;
            var data = { id: this.advertiseId };
            const res = await this.callApi("post", "/delete_advertise_info", data);
            if (res.data.status_code === 200) {
                if (this.deleteImageDetail) {
                    this.handleSuccess()
                }
                this.getVideos();
                this.deleteVideoModal = false;
                this.isSaving = false;
                this.advertiseId = "";
                return this.s("Video was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteVideo(id, video, image) {
            this.deleteVideoModal = true;
            this.videoName = video;
            this.advertiseId = id;
            if (image) {
                this.deleteImageDetail = image
            } else {
                this.deleteImageDetail = ""
            }
        },

        truncatedText(content) {
            const contents = String(content);
            const regex = /<p[^>]*>([^<]+)<\/p>/i;
            const matches = contents.match(regex);
            let text = "";
            if (matches) {
                text = matches[1].replace(/<[^>]+>/g, "");
                text = text.split(" ").slice(0, 50).join(" ");
                if (text !== matches[1].replace(/<[^>]+>/g, "")) {
                    text += "...";
                }
            }
            return text;
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
            response;
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
            const res = await this.callApi("get", "/get_advertise_info");
            if (res.data.status === "success") {
                this.advertises = res.data.data;
                this.tableLoading = false;
            } else {
                this.advertises = [];
                this.tableLoading = false;
            }
        },

        async addNewAdvertiseInfo() {
            this.isSaving = true;
            const res = await this.callApi("post", "/add_new_advertise_info", this.advertise);
            if (res.data.status_code === 201) {
                this.getVideos();
                this.addingModal = false;
                this.isSaving = false;
                this.advertise.content = ""
                this.advertise.lang = ""
                return this.s("New video was added successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }
        },

        viewVideoModal(id, lang, content) {
            this.viewingModal = true;
            this.advertiseId = id;
            this.advertise.content = content
            this.advertise.lang = lang
        },
        editVideoModal(id, lang, content) {
            this.editingModal = true;
            this.advertiseId = id;
            this.advertise.content = content
            this.advertise.lang = lang

        },

        async editVideo() {
            this.isEditing = true;
            const updatedData = { id: this.advertiseId, ...this.advertise };
            const res = await this.callApi("post", "/edit_advertise_info", updatedData);
            if (res.data.status === "success") {
                await this.getVideos();
                this.editingModal = false;
                this.isEditing = false;
                this.advertise.content = ""
                this.advertise.lang = ""
                this.advertiseId = ""
                return this.s("Video infos wa updated successfully");
            } else {
                this.isEditing = false;
                return this.swr();
            }
        },

        closeModal() {
            this.addingModal = false
            this.editingModal = false
            this.viewingModal = false
            this.deleteVideoModal = false
            this.advertise.content = ""
            this.advertise.lang = ""
            this.advertiseId = ""

            // this.$refs[name].resetFields();
        },
    },
};
</script>
