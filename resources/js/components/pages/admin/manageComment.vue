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
                                <!-- <div class="page-title">
                                    <Button @click="addingTagModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add Tag
                                    </Button>
                                </div> -->
                            </div>
                        </div>

                        <div class="col-lg-4 p-l-0 title-margin-left">
                            <div class="page-header">
                                <div class="page-title">
                                    <ol class="breadcrumb text-right">
                                        <li>
                                            <router-link to="dashboard">Dashboard</router-link>
                                        </li>
                                        <li class="active">Comments</li>
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
                                                <tr class="content-center">
                                                    <th width="10%">ID</th>
                                                    <th width="10%">Name</th>
                                                    <th width="20%">Email</th>
                                                    <th width="40%">Comment</th>
                                                    <th width="20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(comment, i) in comments" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>{{ comment.name }}</td>
                                                    <td>{{ comment.email}}</td>
                                                    <td>{{ comment.comment }}</td>
                                                    <td>
                                                        <i-switch @on-change="
                                                            updateStatus( comment.id, comment.status != 'Approved' ? 'Disapproved' : 'Approved')" 
                                                            v-model="comment.status" true-value="Approved" false-value="Disapproved"
                                                            true-color="#13ce66" false-color="#ff4949" size="" />
                                                        <Button
                                                            @click="viewcommentModal(index, comment.id, comment.name, comment.email, comment.comment)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteComment(comment.id)">
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

        <Modal v-model="deleteCommentModal" title="View Tag" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this comment?</strong></p>
                <p><strong>This action cannot be undone. Once deleted, the comment will be permanently removed.</strong></p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteComment()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateTagForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>

        <Modal v-model="viewingModal" :title="comment.name" width="70%">
            <template>
                <Scroll height="450">
                    <div class="text-center">
                        <h1>{{ comment.name }}</h1>
                        <br />
                        <template>
                            <div v-html="comment.comment"></div>
                        </template>
                        <br />
                        <p><strong>Email : </strong>{{ comment.email }}</p>
                    </div>
                </Scroll>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Close
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
            deleteCommentModal: false,
            deleteImageDetail: "",
            isSaving: false,
            comments: [],
            tableLoading: true,
            rowIndex: "",
            commentId: "",
            status: "",
            comment: { name: "", email: "", comment: "", status: "" },
        };
    },

    async created() {
        await this.getComments();
    },

    methods: {

        async confirmDeleteComment() {
            this.isSaving = true;
            var data = {id: this.commentId };
            const res = await this.callApi("post", "/delete_comment", data);
            if (res.data.status_code === 200) {
                this.getComments();
                this.deleteCommentModal = false;
                this.isSaving = false;
                this.commentId = "";
                return this.s("Comment was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteComment(id) {
            this.deleteCommentModal = true;
            this.commentId = id;
        },
        
        truncate(text, length) {
            if (text.length <= length) {
                return text;
            } else {
                return text.slice(0, length) + "...";
            }
        },

        async getComments() {
            const res = await this.callApi("get", "/get_comments");
            console.log(res.data.data)
            if (res.data.status === "success") {
                this.comments = res.data.data;
                this.tableLoading = false;
            } else {
                this.comments = [];
                this.tableLoading = false;
            }
        },

        async updateStatus() {
            this.isSaving = true;
            const res = await this.callApi("post", "/update_comment", this.comment);
            if (res.data.status_code === 200) {
                this.getComments();
            }
        },

        viewcommentModal(index, id, name, email, comment) {
            this.viewingModal = true;
            this.rowIndex = index;
            this.commentId = id;
            this.comment.name = name;
            this.comment.email = email;
            this.comment.comment = comment;
        },

        async updateStatus(id, status) {
            const updatedData = { id: id, status: status };
            const res = await this.callApi("post", "/update_comment_status", updatedData);
            if (res.data.status === "success") {
                await this.getComments();
            }
        },

        closeModal() {
            this.viewingModal = false
            this.addingModal = false
            this.viewingModal = false
            this.deleteCommentModal = false
        },
    }
}

</script>
