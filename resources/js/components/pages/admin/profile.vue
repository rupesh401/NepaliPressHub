<template>
    <div>
        <Navbar />

        <Leftbar />

        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 p-r-0 title-margin-right">
                            <div class="page-header">
                                <div class="page-title">
                                    <h1>Dashboard</h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 p-l-0 title-margin-left">
                            <div class="page-header">
                                <div class="page-title">
                                    <ol class="breadcrumb text-right">
                                        <li> <router-link to="dashboard">Dashboard</router-link></li>
                                        <li class="active">My Profile</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="main-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card alert">
                                    <div class="card-body">
                                        <div class="user-profile">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="user-photo m-b-30">
                                                        <img class="img-responsive"
                                                            v-if="$store.state.userInfos.profile_image"
                                                            :src="`${url_api}uploads/admins/${$store.state.userInfos.profile_image}`"
                                                            height="80px" />
                                                        <img class="img-responsive" v-else
                                                            :src="`${public_asset}profile.png`" alt="User" width="140px" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="user-profile-name">
                                                        {{ $store.state.userInfos.full_name }}
                                                    </div>
                                                    <div v-if="$store.state.userInfos.level == 1" class="user-job-title">
                                                        <strong>As: </strong> Super Administrator
                                                    </div>
                                                    <div v-else class="user-job-title">
                                                        Administrator
                                                    </div>
                                                    <div class="user-job-title">
                                                        <strong> Email: </strong> {{ $store.state.userInfos.email }}
                                                    </div>
                                                    <div class="user-job-title">
                                                        <strong> Phone Number: </strong> {{
                                                            $store.state.userInfos.phone_number }}
                                                    </div>
                                                    <div class="user-send-message">
                                                        <Button @click="activateModal($store.state.userInfos.id)"
                                                            class="mt-4 mb-0" type="warning" shape="circle" icon="md-create"
                                                            ghost></Button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <Button @click="changePasswordModal = true" type="primary"
                                                            ghost>Change Password</Button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card alert">
                                    <div class="card-body">
                                        <div class="user-profile">
                                            <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-8">
                                                    <div class="user-profile-name row">
                                                        <div class="col-lg-9">My Logo</div>
                                                        <div class="col-lg-3">
                                                            <Button @click="activateLogoModal()" class="mt-4 mb-0"
                                                                type="success" shape="circle" icon="md-create" ghost>
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-8">
                                                    <div class="user-photo m-b-30">
                                                        <img style="border-radius: 100%; height: 150px; width: 150px; object-fit: cover;"
                                                            class="img-responsive" v-if="site.logo"
                                                            :src="`${url_api}site/${site.logo}`" />
                                                        <img class="img-responsive" v-else
                                                            :src="`${public_asset}profile.png`" alt="User" width="140px" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4>My Posts</h4>
                                    </div>
                                    <div class="recent-comment">
                                        <div v-for="(post, i) in posts" :key="i" class="media">
                                            <div class="media-left">
                                                <a>
                                                    <img :src="`${url_api}uploads/posts/${post.image}`" class=""
                                                        alt="Post Image"
                                                        style="height: 70px; width: 100px; border-radius: 0px;" />
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{ post.title }}</h4>
                                                <p>{{ truncatedText(post.content) }}</p>
                                                <div class="comment-action">
                                                    <div v-if="post.status === 'Published'" class="badge badge-success">{{
                                                        post.status }}</div>
                                                    <div v-else class="badge badge-alert">{{ post.status }} </div> &nbsp;
                                                </div>
                                                <p class="comment-date">{{ post.created_at | formatDate }}</p>

                                                <p class="comment-date"> &nbsp; &nbsp;Author: {{ post.usr[0].full_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Footer />
                    </div>
                </div>
            </div>
        </div>

        <Modal v-model="addingModal" title="Upload Profile Picture" width="30%">
            <template>
                <Form>
                    <Row>
                        <Col span="24">
                        <template>
                            <Upload action="/upload_profile_picture" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag profile picture here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <Col span="24" v-if="profileData.profile_image">
                        <img :src="`${url_api}uploads/admins/${profileData.profile_image}`" class="img-fluid" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="addingModal = false" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="updateProfilePicture()" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Uploading..." : "Upload Profile" }}
                </Button>
            </div>
        </Modal>
        <Modal v-model="addingLogoModal" title="Upload Site Logo" width="30%">
            <template>
                <Form>
                    <Row>
                        <Col span="24">
                        <template>
                            <Upload action="/upload_logo" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccessLogo" :format="['png', 'jpg', 'jpeg']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag logo here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <Col span="24" v-if="site.logo">
                        <template>
                            <div>
                                <img style="height: 100%; width: 100px; object-fit: cover;"
                                    :src="`${url_api}site/${site.logo}`" class="img-fluid" />
                            </div>
                        </template>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="addingLogoModal = false" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="updateLogo()" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Uploading..." : "Save Logo" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="changePasswordModal" title="Change Password" width="40%">
            <template>
                <Form ref="changePasswordModal" :model="user" :rules="ruleValidate">
                    <Row>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Password" prop="password">
                            <Input v-model="user.password" type="password" placeholder="**********"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Confirm Password" prop="password_confirm">
                            <Input v-model="password_confirm" type="password" placeholder="**********"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('changePasswordModal')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="changePassword('changePasswordModal')" type="primary" :disabled="isEditing"
                    :loading="isEditing">
                    <Icon type="md-document" size="18" />
                    {{ isEditing ? "Changing..." : "Change Password" }}
                </Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import Navbar from "../../inc/navbar";
import Leftbar from "../../inc/leftbar";
import Footer from "../../inc/footer";
import moment from "moment";

export default {
    components: { Navbar, Leftbar, Footer },
    data() {
        return {
            posts: [],
            addingModal: false,
            addingLogoModal: false,
            changePasswordModal: false,
            profileData: { id: "", profile_image: "" },
            site: { id: "", logo: "" },
            user: { id: this.$store.state.userInfos.id, password: "" },
            total: "",
            token: "",
            isEditing: false,
            isSaving: false,
            deleteImageDetail: "",
            password_confirm: "",

            ruleValidate: {
                password: [
                    { required: true, message: "Password cannot be empty!", trigger: "blur" },
                ],
            },
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        this.profileData.profile_image = this.$store.state.userInfos.profile_image;
        await this.getLatestPosts();
        await this.getLogo();
    },

    methods: {

        changePassword(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    if (this.user.password != this.password_confirm) { return this.e('Password does not match!') }
                    this.isEditing = true;
                    const res = await this.callApi("post", "/change_password", this.user);
                    if (res.data.status === "success") {
                        this.changePasswordModal = false;
                        this.isEditing = false;
                        this.user.password = '';
                        this.password_confirm = '';
                        this.$refs[name].resetFields();
                        return this.s("Your password was changed successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
        truncatedText(content) {
            const contents = String(content);
            const regex = /<p[^>]*>([^<]+)<\/p>/i;
            const matches = contents.match(regex);
            let text = "";
            if (matches) {
                text = matches[1].replace(/<[^>]+>/g, "");
                text = text.split(" ").slice(0, 10).join(" ");
                if (text !== matches[1].replace(/<[^>]+>/g, "")) {
                    text += "...";
                }
            }
            return text;
        },
        async updateProfilePicture() {
            this.isSaving = true;
            const res = await this.callApi("post", "/update_profile_picture", this.profileData);
            if (res.data.data) {
                this.$store.commit("updateProfilePicture", this.profileData.profile_image);
                this.addingModal = false;
                this.isSaving = false;
                return this.s("Profile picture was updated successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }
        },
        async updateLogo() {
            this.isSaving = true;
            const res = await this.callApi("post", "/update_logo", this.site);
            if (res.data.data) {
                if (res.data.status_code == 201) {
                    this.addingLogoModal = false;
                    this.isSaving = false;
                    return this.s("Logo was Added successfully");
                } else {
                    this.addingLogoModal = false;
                    this.isSaving = false;
                    return this.s("Logo was updated successfully");
                }
            } else {
                this.isSaving = false;
                return this.swr();
            }
        },

        async handleSuccess(res, file) {
            if (this.deleteImageDetail) {
                var path = this.url_api + "uploads/admins/" + this.deleteImageDetail;
                const response = await this.callApi("post", "/delete_images", { path: path });
                if (response.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            this.profileData.profile_image = res;
        },

        async handleSuccessLogo(res, file) {
            if (this.deleteLogo) {
                var path = this.url_api + "site/" + this.deleteLogo;
                const response = await this.callApi("post", "/delete_images", { path: path });
                if (response.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            this.site.logo = res;
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

        activateModal(id) {
            this.addingModal = true;
            this.profileData.id = id;
            this.deleteImageDetail = this.$store.state.userInfos.profile_image;
        },
        activateLogoModal() {
            this.addingLogoModal = true;
            this.deleteLogo = this.site.logo;
        },

        async getLogo() {
            const res = await this.callApi("get", "/get_logo");
            if (res.data.data.length) {
                this.site.logo = res.data.data[0].logo;
            } else {
                this.site.logo = '';
            }
        },
        async getLatestPosts() {
            const res = await this.callApi("get", "/get_my_latest_four_posts");
            if (res.data.status === "success") {
                this.posts = res.data.data;
                this.total = res.data.total;
            } else {
                this.posts = [];
            }
        },
        closeModal(name) {
            this.addingModal = false;
            this.addingLogoModal = false;
            this.changePasswordModal = false;
            this.user.password = '';
            this.password_confirm = '';
            this.$refs[name].resetFields();
        },
    },
    filters: {
        formatDate(timestamp) {
            const date = moment(timestamp);
            const diffInMinutes = moment().diff(date, "minutes");

            if (diffInMinutes < 1440) {
                return date.fromNow();
            } else {
                return date.fromNow(true);
            }
        },
    },
};
</script>
