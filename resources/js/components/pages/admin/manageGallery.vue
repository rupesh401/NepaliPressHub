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
                                    <Button @click="addingImageModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add Image(s)
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
                                        <li class="active">Gallery</li>
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
                                                    <th width="20%">ID</th>
                                                    <th width="50%">Album Name</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(img, i) in images" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>{{ img.album_title }}</td>
                                                    <td>
                                                        <Button @click="viewImages(img.id, img.album_title, img.img)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button @click="editTagModal(i, img.id)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteAlbum(img.id, img.album_title)">
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

        <Modal v-model="deleteAlbumModal" title="Delete Album" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ image.album_title }}</i> album?</strong></p>
                <p><strong>This action cannot be undone. Once deleted, the album will be permanently removed.</strong></p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteAlbum()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateTagForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>

        <Modal v-model="viewingImageModal" :title="image.album_title + ' - Image '" width="90%">
            <template>
                <div class="text-center">
                    <template>
                        <Row>
                            <Col v-for="(img, i) in image.image" :key="i" span="4">
                            <Card class="image-card">
                                <Button @click="deleteImageInAlbum(img.id, img.image)"
                                    style="width: 12px; height: 12px; font-size: 8px;" type="error" ghost shape="circle"
                                    size="small" icon="md-close" class="close-icon">
                                </Button>
                                <img :src="`${url_api}uploads/gallery/images/${img.image}`" fit="cover" width="100%"
                                    height="100%" />
                            </Card>
                            </Col>
                        </Row>
                    </template>
                </div>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Close
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingImageModal" title="Add Image" width="40%">
            <template>
                <Form ref="addFormValidation" :model="image" :rules="ruleValidate">
                    <Row>
                        <Col span="24">
                        <FormItem label="Album name" prop="title">
                            <Input v-model="image.album_title" type="text" placeholder="Sports News 2023"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <template>
                            <Upload multiple action="/upload_gallery_image" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag image here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <!-- <Col span="24" v-if="image.image">
                        <img :src="`${url_api}uploads/gallery/images/${image.image}`" class="img-fluid" />
                        </Col> -->
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addNewImage('addFormValidation')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingImageModal" title="Edit Image Info" width="40%">
            <template>
                <Form ref="editFormValidation" :model="image" :rules="ruleValidate">
                    <Row>
                        <Col span="24">
                        <FormItem label="Album name" prop="title">
                            <Input v-model="image.album_title" type="text" placeholder="Sports News 2023"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <template>
                            <Upload multiple action="/upload_gallery_image" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag image here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <!-- <Col span="24" v-if="image.image">
                        <img :src="`${url_api}uploads/gallery/images/${image.image}`" class="img-fluid" />
                        </Col> -->
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('editFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editImage('editFormValidation')" type="primary" :disabled="isEditing" :loading="isEditing">
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
            addingImageModal: false,
            viewingImageModal: false,
            editingImageModal: false,
            deleteAlbumModal: false,
            isSaving: false,
            deleteImageDetail: "",
            images: [],
            tableLoading: true,
            keyword: "",
            isEditing: false,
            imageId: "",
            albumId: "",
            rowIndex: "",
            status: "",
            token: "",
            image: { album_title: "", image: [] },

            ruleValidate: {
                album_title: [
                    {
                        required: true,
                        message: "Album name field cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            updateRuleValidate: {
                album_title: [
                    {
                        required: true,
                        message: "Album Name field cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            columns: [
                { title: "Picture", slot: "image", align: "center" },
                { title: "Album", key: "album", align: "center", sortable: true },
                { title: "Status", key: "status", align: "center" },
                { title: "Action", slot: "action", align: "center", width: 190 },
            ],
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getImages();
    },

    methods: {
        async deleteImageInAlbum(id, image) {
            this.isSaving = true;
            var data = { id: id };
            const res = await this.callApi("post", "/delete_image_in_album", data);
            if (res.data.status_code === 200) {
                this.deleteSingleImage(id, image);
                this.deleteAlbumModal = false;
                this.isSaving = false;
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        async confirmDeleteAlbum() {
            this.isSaving = true;
            var data = { id: this.albumId };
            const res = await this.callApi("post", "/delete_album", data);
            if (res.data.status_code === 200) {
                this.getImages();
                this.deleteAlbumModal = false;
                this.isSaving = false;
                this.albumId = "";
                return this.s("Album was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteAlbum(id, album_title) {
            this.deleteAlbumModal = true;
            this.image.album_title = album_title;
            this.albumId = id;
        },
        async deleteSingleImage(id, image) {
            var path = this.url_api + "uploads/gallery/images/" + image;
            const res = await this.callApi("post", "/delete_images", { path: path });
            if (res.data.success == 1) {
                this.getImages();
                this.image.image = this.image.image.filter(img => img.id !== id);
                console.log("image removed");
            } else {
                console.log("image was not deleted in the server");
            }
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
                var path = this.url_api + "uploads/gallery/images/" + this.deleteImageDetail;
                const res = await this.callApi("post", "/delete_images", { path: path });
                if (res.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            // Ensure that this.image.image is an array
            if (!Array.isArray(this.image.image)) {
                this.image.image = []; // Initialize it as an empty array if not already an array
            }

            // this.image.image = response;
            this.image.image.push(response);
            console.log(this.image.image)
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

        async getImages() {
            const res = await this.callApi("get", "/get_images");
            if (res.data.status === "success") {
                this.images = res.data.data;
                console.log(this.images)
                this.tableLoading = false;
            } else {
                this.images = [];
                this.tableLoading = false;
            }
        },

        addNewImage(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_images", this.image);
                    if (res.data.status_code === 201) {
                        this.getImages();
                        this.addingImageModal = false;
                        this.isSaving = false;
                        this.image.image = "";
                        this.$refs[name].resetFields();
                        return this.s("New images was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        viewImages(id, title, image) {
            this.viewingImageModal = true;
            this.imageId = id;
            this.image.album_title = title;
            if (image) {
                this.image.image = image;
            } else {
                this.image.image = "";
            }
        },
        editImageModal(index, id, title, image) {
            this.editingImageModal = true;
            this.imageId = id;
            this.image.album_title = title;
            if (image) {
                this.image.image = image;
                this.deleteImageDetail = image;
            } else {
                this.image.image = "";
            }
        },

        editImage(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.imageId, ...this.image };
                    const res = await this.callApi("post", "/edit_images", updatedData);
                    if (res.data.status === "success") {
                        await this.getImages();
                        this.editingImageModal = false;
                        this.isEditing = false;
                        this.image.image = "";
                        this.$refs[name].resetFields();
                        return this.s("Images infos wa updated successfully");
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
            const res = await this.callApi("post", "/edit_images", updatedData);
            if (res.data.status === "success") {
                await this.getImages();
            }
        },

        closeModal(name) {
            (this.addingImageModal = false),
                (this.editingImageModal = false),
                (this.viewingImageModal = false),
                (this.deleteAlbumModal = false),
                (this.image.image = "");
            this.$refs[name].resetFields();
        },
    },
};
</script>
