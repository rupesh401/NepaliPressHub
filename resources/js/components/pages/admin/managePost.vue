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
                                    <Button @click="(addingModal = true), (clearType = false)" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add New Post
                                    </Button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 p-l-0 title-margin-left">
                            <div class="page-header">
                                <div class="page-title">
                                    <ol class="breadcrumb text-right">
                                        <li>
                                            <router-link to="dashboard">
                                                Dashboard
                                            </router-link>
                                        </li>
                                        <li class="active">Posts</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-content">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12 col-12">
                                <template>
                                    <Form>
                                        <Row>
                                        <Col span="6" class="p-4 m-4">
                                            <Select v-model="categoryFilter" placeholder="Filter by Category" filterable>
                                                <Option value="">All Categories</Option>
                                                <Option v-for="(cat, i) in categories" :key="i" :value="cat.category" >{{ cat.category }}</Option>
                                            </Select>
                                        </Col>
                                        <Col span="6" class="p-4 m-4">
                                            <Select v-model="provinceFilter" placeholder="Filter by Province" filterable>
                                                <Option value="">All Provinces</Option>
                                                <Option v-for="(prov, i) in provinces" :key="i" :value="prov.province">{{ prov.province }}</Option>
                                            </Select>
                                        </Col>
                                        <Col span="6" class="p-4 m-4">
                                            <Select v-model="langFilter" placeholder="Filter by Language" filterable>
                                                <Option value="">All Language</Option>
                                                <Option value="en">English</Option>
                                                <Option value="np">Nepali</Option>
                                            </Select>
                                        </Col>
                                        <Col span="6" class="p-4 m-4">
                                            <Select v-model="statusFilter" placeholder="Filter by Status" filterable>
                                                <Option value="">All Status</Option>
                                                <Option value="published">Published</Option>
                                                <Option value="un published">Un Published</Option>
                                            </Select>
                                        </Col>
                                    </Row>
                                    </Form>
                                    <div>
                                        <!-- Input fields for title and category filters -->
                                        <!-- <Input v-model="titleFilter" placeholder="Search by Title" /> -->
                                    </div>
                                </template>
                                <div class="card alert">
                                    <div class="order-list-item">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <!-- <th>Author</th> -->
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>Tags</th>
                                                    <th>Status</th>
                                                    <th width="25%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(post, i) in newDatas" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <!-- <td>Ferdinand</td> -->
                                                    <td><img v-if="post.image" class="img-fluid" width="60"
                                                            style="border-radius: 10%"
                                                            :src="`${url_api}uploads/posts/${post.image}`"
                                                            alt="Post Image" /></td>
                                                    <td>{{ post.title }}</td>
                                                    <td>
                                                        <p>{{ truncatedText(post.content) }}</p>
                                                    </td>
                                                    <td>{{ post.cat[0].category }}</td>
                                                    <td>
                                                        <span v-for="(t, i) in post.tag" :key="i">
                                                            <Tag :color="tagColor(i)" type="border">{{ t.tag }}</Tag>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <Button v-if="post.status == 'Published'" type="success"
                                                            size="small">
                                                            {{ post.status }}
                                                        </Button>
                                                        <Button v-else type="error" size="small">
                                                            {{ post.status }}
                                                        </Button>
                                                    </td>
                                                    <td>
                                                        <i-switch @on-change="
                                                            updateStatus(
                                                                post.id,
                                                                post.status != 'Published' ? 'Un published' : 'Published'
                                                            )
                                                            " v-model="post.status" true-value="Published"
                                                            false-value="Un published" true-color="#13ce66"
                                                            false-color="#ff4949" size="small" />
                                                        <Button
                                                            @click="viewPostModal(i, post.id, post.title, post.content, post.cat, post.tag, post.image, post.slug)">
                                                            <Icon type="ios-eye-outline" color="blue" size="15" />
                                                        </Button>
                                                        <Button
                                                            @click="editPostModal(i, post.id, post.title, post.content, post.cat, post.prov, post.tag, post.image, post.lang, post.flash_news)">
                                                            <Icon type="ios-create-outline" color="green" size="15" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deletePost(post.id, post.title)">
                                                            <Icon type="ios-trash-outline" color="red" size="15" />
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

        <Modal v-model="deletePostModal" title="View Tag" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this "<i>{{ titleName }}</i> " post?</strong></p>
                <p>This action cannot be undone. Once deleted, the post will be permanently removed.</p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeletePost()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateTagForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewingModal" :title="post.title" width="50%">
            <template>
                <Scroll height="450">
                    <iframe style="border-radius: 12px; border: 2px solid green" :src="urlPost" width="100%"
                        height="440"></iframe>
                </Scroll>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Close
                </Button>
            </div>
        </Modal>
        <Modal v-model="addingModal" title="Add Post" width="70%">
            <template>
                <Form ref="addFormValidation" :model="post" :rules="ruleValidate">
                    <Row>
                        <Col span="16">
                        <FormItem label="Post Title" prop="title">
                            <Input v-model="post.title" type="text" placeholder="Write news title here ...."></Input>
                        </FormItem>
                        </Col>
                        <Col span="3" class="p-4 m-4" offset="1">
                        <FormItem label="Language" prop="lang">
                            <Select v-model="post.lang" filterable>
                                <Option value="en">English</Option>
                                <Option value="np">Nepali</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="3" offset="1">
                        <FormItem label="Flash News?" prop="flash_news">
                            <Checkbox v-model="post.flash_news"></Checkbox>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <template>
                            <vue-editor useCustomImageHandler @image-added="handleImageAdded"
                                @image-removed="handleImageRemoved" ref="editors" v-model="post.content" />
                        </template>
                        </Col>
                        <Col span="24">
                        <Upload class="mt-1" action="/upload_post_image" type="drag" :headers="{ 'x-csrf-token': token }"
                            :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                            :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                <p>Click or drag post picture here to upload</p>
                            </div>
                        </Upload>
                        </Col>
                        <Col span="24" v-if="post.image">
                        <img style="width: 100%; object-fit: cover;" :src="`${url_api}uploads/posts/${post.image}`"
                            class="img-fluid" />
                        </Col>
                        <Col span="7">
                        <FormItem label="Category" prop="category">
                            <Select v-model="post.category" filterable>
                                <Option v-for="(cat, i) in categories" :key="i" :value="cat.id">{{
                                    cat.category
                                }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="7" offset="1">
                        <FormItem label="Tags" prop="tags">
                            <Select v-model="post.tags" filterable multiple>
                                <Option v-for="(tag, i) in tags" :key="i" :value="tag.id">{{
                                    tag.tag
                                }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="3" offset="1">
                        <FormItem label="With Province" prop="with_province">
                            <Checkbox v-model="checkbox"></Checkbox>
                        </FormItem>
                        </Col>
                        <Col v-if="checkbox" span="4" offset="1">
                        <FormItem label="Province" prop="province">
                            <Select v-model="post.province" filterable>
                                <Option v-for="(prov, i) in provinces" :key="i" :value="prov.id">{{
                                    prov.province
                                }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addPost('addFormValidation')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingModal" title="Edit Post Info" width="70%">
            <template>
                <Form ref="editFormValidation" :model="post" :rules="ruleValidate">
                    <Row>
                        <Col span="16">
                        <FormItem label="Post Title" prop="title">
                            <Input v-model="post.title" type="text" placeholder="Write news title here ...."></Input>
                        </FormItem>
                        </Col>
                        <Col span="3" class="p-4 m-4" offset="1">
                        <FormItem label="Language" prop="lang">
                            <Select v-model="post.lang" filterable>
                                <Option value="en">English</Option>
                                <Option value="np">Nepali</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="3" offset="1">
                        <FormItem label="Flash News?" prop="flash_news">
                            <Checkbox v-model="post.flash_news"></Checkbox>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <template>
                            <vue-editor useCustomImageHandler @image-added="handleImageAdded"
                                @image-removed="handleImageRemoved" ref="editors" v-model="post.content" />
                        </template>
                        </Col>
                        <Col span="24">
                        <Upload class="mt-1" action="/upload_post_image" type="drag" :headers="{ 'x-csrf-token': token }"
                            :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                            :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                <p>Click or drag post picture here to upload</p>
                            </div>
                        </Upload>
                        </Col>
                        <Col span="24" v-if="post.image">
                        <img style="width: 100%; object-fit: cover;" :src="`${url_api}uploads/posts/${post.image}`"
                            class="img-fluid" />
                        </Col>
                        <Col span="7">
                        <FormItem label="Category" prop="category">
                            <Select v-model="post.category" filterable>
                                <Option v-for="(cat, i) in categories" :key="i" :value="cat.id">{{
                                    cat.category
                                }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="7" offset="1">
                        <FormItem label="Tags" prop="tags">
                            <Select v-model="post.tags" filterable multiple>
                                <Option v-for="(tag, i) in tags" :key="i" :value="tag.id">{{
                                    tag.tag
                                }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="3" offset="1">
                        <FormItem label="With Province" prop="with_province">
                            <Checkbox v-model="checkbox"></Checkbox>
                        </FormItem>
                        </Col>
                        <Col v-if="checkbox" span="4" offset="1">
                        <FormItem label="Province" prop="province">
                            <Select v-model="post.province" filterable>
                                <Option v-for="(prov, i) in provinces" :key="i" :value="prov.id">{{
                                    prov.province
                                }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('editFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editPost('editFormValidation')" type="primary" :disabled="isEditing" :loading="isEditing">
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
            deletePostModal: false,
            deleteImageDetail: "",
            isSaving: false,
            clearType: false,
            posts: [],
            // newDatas: [],
            filteredPosts: [],
            titleFilter: "",
            categoryFilter: "",
            provinceFilter: "",
            langFilter: "",
            statusFilter: "",
            tags: [],
            provinces: [],
            categories: [],
            textTag: [],
            tableLoading: true,
            keyword: "",
            editingModal: false,
            isEditing: false,
            postId: "",
            titleName: "",
            rowIndex: "",
            status: "",
            token: "",
            url: "",
            urlPost: "",
            checkbox: false,
            post: { title: "", content: "", category: "", tags: [], image: "", province: '', lang: "en", flash_news: false },
            tag: { name: "" },

            ruleValidate: {
                title: [
                    {
                        required: true,
                        message: "Post title cannot be empty.",
                        trigger: "blur",
                    },
                ],
                content: [
                    {
                        required: true,
                        message: "Post content cannot be empty.",
                        trigger: "blur",
                    },
                ],
                // category: [
                //     {
                //         required: true,
                //         message: "Post category cannot be empty.",
                //         trigger: "change",
                //     },
                // ],
                // province: [],
                tags: [
                    {
                        required: true,
                        type: "array",
                        min: 1,
                        message: "Please select at least one tag",
                        trigger: "change",
                    },
                ],
            },

            updateRuleValidate: {
                title: [
                    {
                        required: true,
                        message: "Post title cannot be empty.",
                        trigger: "blur",
                    },
                ],
                content: [
                    {
                        required: true,
                        message: "Post content cannot be empty.",
                        trigger: "blur",
                    },
                ],
                // category: [
                //     {
                //         required: true,
                //         message: "Post category cannot be empty.",
                //         trigger: "change",
                //     },
                // ],
                // province: [],
                tags: [
                    {
                        required: true,
                        type: "array",
                        min: 1,
                        message: "Please select at least one tag",
                        trigger: "change",
                    },
                ],
            },

            validateTag: {
                name: [
                    {
                        required: true,
                        message: "Tag name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            columns: [
                { title: "Picture", slot: "image", align: "center" },
                { title: "Title", key: "title", align: "center", sortable: true },
                { title: "Content", slot: "content", align: "center", width: 200 },
                { title: "Categorry", slot: "cats", align: "center", sortable: true },
                { title: "Tags", slot: "tags", align: "center" },
                { title: "Status", key: "status", align: "center" },
                { title: "Action", slot: "action", align: "center", width: 190 },
            ],
        };
    },

    // watch: {
    //     checkbox(newValue) {
    //         this.validateProvince(newValue);
    //     },
    // },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getPosts();
        await this.getTags();
        await this.getProvinces();
        await this.getCategory();
    },

    computed: {
        // Apply filters to the posts
        newDatas() {
            let filteredPosts = this.posts;

            // Apply title filter
            if (this.titleFilter) {
                filteredPosts = filteredPosts.filter(post =>
                    post.title.toLowerCase().includes(this.titleFilter.toLowerCase())
                );
            }

            // Apply category filter
            if (this.categoryFilter) {
                filteredPosts = filteredPosts.filter(post =>
                    post.cat[0].category.toLowerCase().includes(this.categoryFilter.toLowerCase())
                );
            }
            // Apply province filter
            if (this.provinceFilter) {
                filteredPosts = filteredPosts.filter(post => {
                    if (post.prov && post.prov.length > 0) {
                        return post.prov[0].province.toLowerCase().includes(this.provinceFilter.toLowerCase());
                    } else {
                        return false; // Exclude posts without valid province information
                    }
                });
            }// Apply province filter
            if (this.provinceFilter) {
                filteredPosts = filteredPosts.filter(post => {
                    if (post.prov && post.prov.length > 0) {
                        return post.prov[0].province.toLowerCase().includes(this.provinceFilter.toLowerCase());
                    } else {
                        return false; // Exclude posts without valid province information
                    }
                });
            }
            // Apply language filter
            if (this.langFilter) {
                filteredPosts = filteredPosts.filter(post =>
                    post.lang.toLowerCase().includes(this.langFilter.toLowerCase())
                );
            }
            // Apply status filter
            if (this.statusFilter) {
                filteredPosts = filteredPosts.filter(post => {
                    const status = post.status.toLowerCase();
                    return (
                        (this.statusFilter.toLowerCase() === "published" && status === "published") ||
                        (this.statusFilter.toLowerCase() === "un published" && status.includes("un published"))
                    );
                });
            }
            return filteredPosts;
        }
    },

    methods: {

        validateProvince(shouldValidate = this.checkbox) {
            if (shouldValidate) {
                // Add the validation rule for province when checkbox is true
                this.$set(
                    this.ruleValidate,
                    "province",
                    [
                        {
                            required: true,
                            message: "Post province cannot be empty.",
                            trigger: "change",
                        },
                    ]
                );
            } else {
                // Remove the validation rule for province when checkbox is false
                this.$delete(this.ruleValidate, "province");
            }

        },

        async confirmDeletePost() {
            this.isSaving = true;
            var data = { id: this.postId };
            const res = await this.callApi("post", "/delete_post", data);
            if (res.data.status_code === 200) {
                this.getPosts();
                this.deletePostModal = false;
                this.isSaving = false;
                this.postId = "";
                return this.s("Post was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deletePost(id, title) {
            this.deletePostModal = true;
            this.titleName = title;
            this.postId = id;
        },
        tagColor(index) {
            const colors = [
                "warning",
                "magenta",
                "red",
                "volcano",
                "gold",
                "yellow",
                "lime",
                "green",
                "cyan",
                "blue",
                "geekblue",
                "purple",
                "error",
                "success",
                "primary",
            ];

            const randomIndex = Math.floor(Math.random() * colors.length);
            const color = colors[randomIndex];
            if (index % 2 === 0) {
                return color;
            } else {
                let colorIndex = colors.indexOf(color);
                let nextColorIndex = (colorIndex + 1) % colors.length;
                let nextColor = colors[nextColorIndex];
                return nextColor;
            }
        },
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
        modifyHtmlTags() {
            let regexBreak = /<p>([^<]*<br>[^<]*)<\/p>/gi;
            let formattedContent = this.post.content.replace(regexBreak, "<br>");

            let regex = /(<h[1-6][^>]*)(>)/gi;
            let formattedContents = formattedContent.replace(
                regex,
                '$1 class="event-details__text-5"$2'
            );
            let regexPtag = /(<p[^>]*)(>)/gi;
            formattedContents = formattedContents.replace(
                regexPtag,
                '$1 class="news-details__text-2"$2'
            );

            this.post.content = formattedContents;
        },

        truncate(text, length) {
            if (text.length <= length) {
                return text;
            } else {
                return text.slice(0, length) + "...";
            }
        },
        async handleSuccess(res, file) {
            if (this.deleteImageDetail) {
                var path = this.url_api + "uploads/posts/" + this.deleteImageDetail;
                const response = await this.callApi("post", "/delete_images", { path: path });
                if (response.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            this.post.image = res;
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

        async getPosts() {
            const res = await this.callApi("get", "/get_posts");
            if (res.data.status === "success") {
                this.posts = res.data.data;
                this.tableLoading = false;
            } else {
                this.posts = [];
                this.tableLoading = false;
            }
        },

        addPost(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_post", this.post);
                    if (res.data.status_code === 201) {
                        this.getPosts();
                        this.addingModal = false;
                        this.isSaving = false;
                        this.post.image = "";
                        this.textTag = [];
                        this.post.content = "";
                        this.$refs.editors = '';
                        this.checkbox = false;
                        this.post.province = '';
                        this.post.category = "";
                        this.$refs[name].resetFields();
                        this.clearType = true;
                        return this.s("New post was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        async getTags() {
            const res = await this.callApi("get", "/get_tags");
            if (res.data.status === "success") {
                this.tags = res.data.data;
            } else {
                this.tags = [];
            }
        },

        async getProvinces() {
            const res = await this.callApi("get", "/get_provinces");
            if (res.data.status === "success") {
                this.provinces = res.data.data;
            } else {
                this.provinces = [];
            }
        },

        async getCategory() {
            const res = await this.callApi("get", "/get_categories");
            if (res.data.status === "success") {
                this.categories = res.data.data;
                this.tableLoading = false;
            } else {
                this.categories = [];
            }
        },

        viewPostModal(index, id, title, content, category, tags, image, url) {
            this.viewingModal = true;
            this.rowIndex = index;
            this.postId = id;
            this.post.title = title;
            this.post.content = content;
            this.post.category = category;
            this.urlPost = "/posts/" + url;
            for (let t of tags) {
                this.textTag.push(t.tag);
            }
            if (image) {
                this.post.image = image;
            } else {
                this.post.image = "";
            }
        },
        editPostModal(index, id, title, content, category, province, tags, image, lang, flash_news) {
            this.editingModal = true;
            this.clearType = false;
            this.rowIndex = index;
            this.postId = id;
            this.post.title = title;
            this.post.content = content;
            this.post.lang = lang;
            if (flash_news === 1) {
                this.post.flash_news = true;
            } else {
                this.post.flash_news = false;
            }
            if (province.length) {
                this.checkbox = true
                this.post.province = province[0].id;
            }
            this.post.category = category[0].id;
            this.post.tags = [];
            for (let t of tags) {
                this.post.tags.push(t.id);
            }
            if (image) {
                this.post.image = image;
                this.deleteImageDetail = image;
            } else {
                this.post.image = "";
            }

            // Remove all class attributes from HTML string
            let formattedContent = content.replace(/class="[^"]*"/g, "");

            // Remove class attribute from <p> tags
            formattedContent = formattedContent.replace(
                /(<p\s[^>]*)(\sclass=["'][^"']*["'])?([^>]*>)/gi,
                "$1$3"
            );

            // Remove class attribute from <h1> to <h6> tags
            formattedContent = formattedContent.replace(
                /(<h[1-6]\s[^>]*)(\sclass=["'][^"']*["'])?([^>]*>)/gi,
                "$1$3"
            );

            this.post.content = formattedContent;
        },

        editPost(name) {
            this.clearType = true;
            // this.modifyHtmlTags();
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    if (this.checkbox != true) {
                        this.post.province = ''
                    }
                    const updatedData = { id: this.postId, ...this.post };
                    const res = await this.callApi("post", "/edit_post", updatedData);
                    if (res.data.status === "success") {
                        await this.getPosts();
                        this.editingModal = false;
                        this.isEditing = false;
                        this.post.image = "";
                        this.textTag = [];
                        this.post.content = "";
                        this.post.category = "";
                        this.$refs.editors = '';
                        this.checkbox = false;
                        this.post.province = '';
                        this.$refs[name].resetFields();
                        return this.s("Post infos wa updated successfully");
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
            const res = await this.callApi("post", "/edit_post", updatedData);
            if (res.data.status === "success") {
                await this.getPosts();
            }
        },

        searchPost() {
            return this.posts.filter((object) => {
                return (
                    object.title.toLowerCase().includes(this.keyword.toLowerCase()) ||
                    object.email.toLowerCase().includes(this.keyword.toLowerCase()) ||
                    object.phone_number.toLowerCase().includes(this.keyword.toLowerCase())
                );
            });
        },

        closeModal(name) {
            this.clearType = true;
            this.addingModal = false;
            this.editingModal = false;
            this.viewingModal = false;
            this.addingTagModal = false;
            this.post.image = "";
            this.textTag = [];
            this.post.content = "";
            this.post.category = "";
            this.$refs.editors = '';
            this.checkbox = false;
            this.post.province = "";
            this.$refs[name].resetFields();
        },
    },
};
</script>
