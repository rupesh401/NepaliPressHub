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
                                    <Button @click="addingNewsModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add Breaking News
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
                                        <li class="active">Breaking News</li>
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
                                                    <th width="10%">ID</th>
                                                    <th width="50%">Title</th>
                                                    <th width="15%">Language</th>
                                                    <th width="25%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(news, i) in breakingNews" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>{{ news.title }}</td>
                                                    <td v-if="news.lang === 'en'">English</td>
                                                    <td v-else>Nepal</td>
                                                    <td>
                                                        <Button @click="viewNews(news.title)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button @click="editNewsModal(i, news.id, news.title, news.lang)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteNews(news.id, news.title)">
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

        <Modal v-model="deleteNewsModal" title="View News" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ newsTitle }}</i> news?</strong></p>
                <p>This action cannot be undone. Once deleted, the news will be permanently removed.</p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteNews()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateNewsForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewNewsModal" title="View Breaking News" width="40%" class="text-center">
            <template>{{ newsTitle }}</template>
            <div slot="footer">
                <Button @click="closeModal('validateNewsForm')" type="success">
                    <Icon type="ios-done-all" size="18" />
                    Ok
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingNewsModal" title="Add News" width="55%">
            <template>
                <Form ref="validateNewsForm" :model="news" :rules="validateNews">
                    <Row>
                        <Col span="19">
                        <FormItem label="News" prop="news">
                            <Input v-model="news.title" type="text" placeholder="Write title for breaking news ..."></Input>
                        </FormItem>
                        </Col>
                        <Col span="4" offset="1">
                        <FormItem label="Language" prop="lang">
                            <Select v-model="news.lang" filterable>
                                <Option value="en">English</Option>
                                <Option value="np">Nepali</Option>
                            </Select>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateNewsForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addNews('validateNewsForm')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingNewsModal" title="Edit News" width="55%">
            <template>
                <Form ref="validateEditNewsForm" :model="news" :rules="validateNews">
                    <Row>
                        <Col span="19">
                        <FormItem label="Post Title" prop="title">
                            <Input v-model="news.title" type="text" placeholder="Tech"></Input>
                        </FormItem>
                        </Col>
                        <Col span="4" offset="1">
                        <FormItem label="Language" prop="lang">
                            <Select v-model="news.lang" filterable>
                                <Option value="en">English</Option>
                                <Option value="np">Nepali</Option>
                            </Select>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateEditNewsForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editNews('validateEditNewsForm')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Updating..." : "Update" }}
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
            addingNewsModal: false,
            editingNewsModal: false,
            deleteNewsModal: false,
            viewNewsModal: false,
            isSaving: false,
            breakingNews: [],
            textNews: [],
            tableLoading: true,
            keyword: "",
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            newsTitle: "",
            newsId: "",
            news: { title: "", lang: "" },

            validateNews: {
                title: [
                    {
                        required: true,
                        message: "Title cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
            validateUpdateNews: {
                title: [
                    {
                        required: true,
                        message: "Title cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getBreakingNews();
    },

    computed: {},

    methods: {
        async confirmDeleteNews() {
            this.isSaving = true;
            var data = { id: this.newsId };
            const res = await this.callApi("post", "/delete_breaking_news", data);
            if (res.data.status_code === 200) {
                this.getBreakingNews();
                this.deleteNewsModal = false;
                this.isSaving = false;
                this.newsId = "";
                return this.s("Breaking News was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteNews(id, news) {
            this.deleteNewsModal = true;
            this.newsTitle = news;
            this.newsId = id;
        },
        viewNews(news) {
            this.viewNewsModal = true;
            this.newsTitle = news;
        },
        newsColor(index) {
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

        async getBreakingNews() {
            const res = await this.callApi("get", "/get_breaking_news");
            if (res.data.status === "success") {
                this.breakingNews = res.data.data;
                this.tableLoading = false;
            } else {
                this.breakingNews = [];
            }
        },

        addNews(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    if (this.news.lang === '') {
                        this.news.lang = 'en'
                    }
                    const res = await this.callApi("post", "/add_new_breaking_news", this.news);
                    if (res.data.status_code === 201) {
                        this.getBreakingNews();
                        this.addingNewsModal = false;
                        this.isSaving = false;
                        this.news.title = "";
                        this.news.lang = "";
                        this.$refs[name].resetFields();
                        return this.s("Breaking News was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
        editNewsModal(index, id, name, lang) {
            this.editingNewsModal = true;
            this.rowIndex = index;
            this.newsId = id;
            this.news.title = name;
            this.news.lang = lang;
        },

        editNews(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    if (this.news.lang === '') {
                        this.news.lang = 'en'
                    }
                    this.isEditing = true;
                    const updatedData = { id: this.newsId, ...this.news };
                    const res = await this.callApi("post", "/edit_breaking_news", updatedData);
                    if (res.data.status === "success") {
                        await this.getBreakingNews();
                        this.editingNewsModal = false;
                        this.isEditing = false;
                        this.news.title = "";
                        this.news.lang = '';
                        this.$refs[name].resetFields();
                        return this.s("Breaking News updated successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        closeModal(name) {
            this.addingNewsModal = false;
            this.news.title = '';
            this.news.lang = '';
            this.editingNewsModal = false;
            this.deleteNewsModal = false;
            this.viewNewsModal = false;
            this.$refs[name].resetFields();
        },
    },
};
</script>
