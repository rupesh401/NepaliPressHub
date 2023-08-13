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
                                    <Button @click="addingTagModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add Tag
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
                                        <li class="active">Tags</li>
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
                                                    <th width="50%">Tag</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(tag, i) in tags" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>
                                                        <Tag :color="tagColor(i)" type="border">{{ tag.tag }}</Tag>
                                                    </td>
                                                    <td>
                                                        <Button @click="viewTag(tag.tag)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button @click="editTagModal(i, tag.id, tag.tag)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1" @click="deleteTag(tag.id, tag.tag)">
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

        <Modal v-model="deleteTagModal" title="Delete Tag" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ tagName }}</i> tag?</strong></p>
                <p><strong>This action cannot be undone. Once deleted, the tag will be permanently removed.</strong></p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteTag()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateTagForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        
        <Modal v-model="viewTagModal" title="View Tag" width="30%" class="text-center">
            <template>
                <Tag :color="tagColor(1)" type="border">{{ tagName }}</Tag>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateTagForm')" type="success">
                    <Icon type="ios-done-all" size="18" />
                    Ok
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingTagModal" title="Add Tag" width="30%">
            <template>
                <Form ref="validateTagForm" :model="tag" :rules="validateTag">
                    <Row>
                        <Col span="24">
                        <FormItem label="Tag" prop="title">
                            <Input v-model="tag.name" type="text" placeholder="Tech"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateTagForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addTag('validateTagForm')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingTagModal" title="Edit Tag" width="30%">
            <template>
                <Form ref="validateEditTagForm" :model="tag" :rules="validateTag">
                    <Row>
                        <Col span="24">
                        <FormItem label="Tag" prop="title">
                            <Input v-model="tag.name" type="text" placeholder="Tech"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateEditTagForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editTag('validateEditTagForm')" type="primary" :disabled="isSaving" :loading="isSaving">
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
            addingTagModal: false,
            viewTagModal: false,
            editingTagModal: false,
            deleteTagModal: false,
            isSaving: false,
            tags: [],
            textTag: [],
            tableLoading: true,
            keyword: "",
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            tagId: "",
            tagName: '',
            tag: { name: "", },

            validateTag: {
                name: [
                    {
                        required: true,
                        message: "Tag name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
            validateUpdateTag: {
                name: [
                    {
                        required: true,
                        message: "Tag name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            columns: [
                { title: "ID", slot: "number", sortable: true },
                { title: "Tag Name", slot: "name", align: "center" },
                { title: "Action", slot: "action", align: "center" },
            ],
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getTags();
    },

    computed: {},

    methods: {

        async confirmDeleteTag() {
            this.isSaving = true;
            var data = {id: this.tagId };
            const res = await this.callApi("post", "/delete_tag", data);
            if (res.data.status_code === 200) {
                this.getTags();
                this.deleteTagModal = false;
                this.isSaving = false;
                this.tagId = "";
                return this.s("Tag was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteTag(id, tag) {
            this.deleteTagModal = true;
            this.tagName = tag;
            this.tagId = id;
        },
        viewTag(tag) {
            this.viewTagModal = true;
            this.tagName = tag;
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

        async getTags() {
            const res = await this.callApi("get", "/get_tags");
            if (res.data.status === "success") {
                this.tags = res.data.data;
                this.tableLoading = false;
            } else {
                this.tags = [];
            }
        },

        addTag(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_tag", this.tag);
                    if (res.data.status_code === 201) {
                        this.getTags();
                        this.addingTagModal = false;
                        this.isSaving = false;
                        this.tag.name = "";
                        this.$refs[name].resetFields();
                        return this.s("New tag was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
        editTagModal(index, id, name) {
            this.editingTagModal = true;
            this.rowIndex = index;
            this.tagId = id;
            this.tag.name = name;
        },

        editTag(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.tagId, ...this.tag };
                    const res = await this.callApi("post", "/edit_tag", updatedData);
                    if (res.data.status === "success") {
                        await this.getTags();
                        this.editingTagModal = false;
                        this.isEditing = false;
                        this.tag.name = "";
                        this.$refs[name].resetFields();
                        return this.s("Tag infos was updated successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        closeModal(name) {
            this.addingTagModal = false;
            this.viewTagModal = false;
            this.deleteTagModal = false;
            this.editingTagModal = false;
            this.$refs[name].resetFields();
        },
    },
};
</script>
