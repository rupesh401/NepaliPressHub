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
                                        <li class="active">Our Story</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-content">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card alert">
                                    <div class="order-list-item">
                                        <template>
                                            <div class="row">
                                                <div
                                                    :class="{ 'col-lg-8 col-md-8 col-sm-12 col-xs-12 offset-lg-2 offset-md-2': hideAbout, 'col-lg-6 col-md-6 col-sm-12 col-xm-12': !hideAbout }">
                                                    <template>
                                                        <Form ref="addFormValidation" :model="about" :rules="ruleValidate">
                                                            <Row>
                                                                <Col span="24">
                                                                <template>
                                                                <FormItem label="Our Story" prop="about_us">
                                                                    <vue-editor useCustomImageHandler
                                                                        @image-added="handleImageAdded"
                                                                        @image-removed="handleImageRemoved" ref="editors"
                                                                        v-model="about.about_us" />
                                                                </FormItem>
                                                                </template>
                                                                </Col>
                                                               
                                                                <Col class="mt-4" span="23">
                                                                <Button @click="addAbout('addFormValidation')"
                                                                    type="primary" :disabled="inputDisable"
                                                                    :loading="isSaving" long ghost size="large">
                                                                    <Icon type="md-document" size="18" />
                                                                    {{ isSaving ? "Saving..." : "Save" }}
                                                                </Button>
                                                                </Col>
                                                            </Row>
                                                        </Form>
                                                    </template>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="text-center">
                                                        <div v-if="hideAbout == false"
                                                            class="table-responsive social_media_table">
                                                            <div v-if="about.about_us">
                                                                <h1 v-if="about.about_us">Our Story</h1>
                                                                <hr v-if="about.about_us" /><br><br>
                                                                <p v-html="about.about_us"></p><br><br>
                                                                <!-- <p>{{ about.about_us }}</p><br><br> -->

                                                                <Col span="22" offset="1" class="mb-4">
                                                                <Button @click="
                                                                    (inputDisable = false),
                                                                    (hideAbout = true)
                                                                    " type="primary" :loading="isSaving" long ghost
                                                                    size="large">
                                                                    <Icon size="18" />
                                                                    Edit
                                                                </Button>
                                                                </Col>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
            inputDisable: false,
            hideAbout: false,
            isSaving: false,
            abouts: [],
            tableLoading: true,
            keyword: "",
            editingModal: false,
            isEditing: false,
            aboutId: "",
            rowIndex: "",
            status: "",
            token: "",
            about: {
                id: "",
                about_us: "",
            },

            ruleValidate: {
                about_us: [
                    {
                        required: true,
                        message: "This field cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getAbouts();
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
            formData.append("path", "uploads/posts");
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
            console.log("succes twoo man");
            if (this.deleteImageTwo) {
                var path = this.url_api + "uploads/abouts/" + this.deleteImageTwo;
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
                var path = this.url_api + "uploads/abouts/" + this.deleteImageOne;
                const response = await this.callApi("post", "/delete_images", { path: path });
                if (response.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            this.about.image = res;
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

        async getAbouts() {
            const res = await this.callApi("get", "/get_abouts");
            if (res.data.data.length) {
                var abouts = res.data.data;
                this.about.id = abouts[0].id;
                this.about.about_us = abouts[0].about_us;
                this.inputDisable = true;
            } else {
            }
        },

        addAbout(name) {
            if (this.hideAbout) {
                this.editAbout(name);
            } else {
                this.$refs[name].validate(async (valid) => {
                    if (valid) {
                        this.isSaving = true;
                        const res = await this.callApi("post", "/add_new_about", this.about);
                        if (res.data.status_code === 201) {
                            this.getAbouts();
                            this.hideAbout = false;
                            this.isSaving = false;
                            this.$refs[name].resetFields();
                            return this.s("About us infos was added successfully");
                        } else {
                            this.isSaving = false;
                            return this.swr();
                        }
                    } else {
                    }
                });
            }
        },

        editAbout(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    const res = await this.callApi("post", "/edit_about", this.about);
                    if (res.data.status === "success") {
                        await this.getAbouts();
                        this.hideAbout = false;
                        this.isSaving = false;
                        return this.s("About infos wa updated successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
    },
};
</script>
