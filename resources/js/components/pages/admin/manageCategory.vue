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
                                    <Button @click="addingCategoryModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add Category
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
                                        <li class="active">Categories</li>
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
                                                    <th width="50%">Category</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(category, i) in categories" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>
                                                        <Tag :color="categoryColor(i)" type="border">{{ category.category }}
                                                        </Tag>
                                                    </td>
                                                    <td>
                                                        <Button @click="viewCategory(category.category)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button @click="editCategoryModal(i, category.id, category.category)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteCategory(category.id, category.category)">
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

        <Modal v-model="deleteCategoryModal" title="View Category" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ categoryName }}</i> category?</strong></p>
                <p>This action cannot be undone. Once deleted, the category will be permanently removed.</p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteCategory()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateCategoryForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewCategoryModal" title="View Category" width="30%" class="text-center">
            <template>
                <Tag :color="categoryColor(1)" type="border">{{ categoryName }}</Tag>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateCategoryForm')" type="success">
                    <Icon type="ios-done-all" size="18" />
                    Ok
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingCategoryModal" title="Add Category" width="30%">
            <template>
                <Form ref="validateCategoryForm" :model="category" :rules="validateCategory">
                    <Row>
                        <Col span="24">
                        <FormItem label="Category" prop="category">
                            <Input v-model="category.name" type="text" placeholder="Province"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateCategoryForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addCategory('validateCategoryForm')" type="primary" :disabled="isSaving"
                    :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingCategoryModal" title="Edit Category" width="30%">
            <template>
                <Form ref="validateEditCategoryForm" :model="category" :rules="validateCategory">
                    <Row>
                        <Col span="24">
                        <FormItem label="Post Title" prop="title">
                            <Input v-model="category.name" type="text" placeholder="Tech"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateEditCategoryForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editCategory('validateEditCategoryForm')" type="primary" :disabled="isSaving"
                    :loading="isSaving">
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
            addingCategoryModal: false,
            editingCategoryModal: false,
            deleteCategoryModal: false,
            viewCategoryModal: false,
            isSaving: false,
            categories: [],
            textCategory: [],
            tableLoading: true,
            keyword: "",
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            categoryName: "",
            categoryId: "",
            category: { name: "" },

            validateCategory: {
                name: [
                    {
                        required: true,
                        message: "Category name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
            validateUpdateCategory: {
                name: [
                    {
                        required: true,
                        message: "Category name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            columns: [
                { title: "ID", slot: "number", sortable: true },
                { title: "Category Name", slot: "name", align: "center" },
                { title: "Action", slot: "action", align: "center" },
            ],
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getCategories();
    },

    computed: {},

    methods: {
        async confirmDeleteCategory() {
            this.isSaving = true;
            var data = { id: this.categoryId };
            const res = await this.callApi("post", "/delete_category", data);
            if (res.data.status_code === 200) {
                this.getCategories();
                this.deleteCategoryModal = false;
                this.isSaving = false;
                this.categoryId = "";
                return this.s("Category was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteCategory(id, category) {
            this.deleteCategoryModal = true;
            this.categoryName = category;
            this.categoryId = id;
        },
        viewCategory(category) {
            this.viewCategoryModal = true;
            this.categoryName = category;
        },
        categoryColor(index) {
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

        async getCategories() {
            const res = await this.callApi("get", "/get_categories");
            if (res.data.status === "success") {
                this.categories = res.data.data;
                this.tableLoading = false;
            } else {
                this.categories = [];
            }
        },

        addCategory(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_category", this.category);
                    if (res.data.status_code === 201) {
                        this.getCategories();
                        this.addingCategoryModal = false;
                        this.isSaving = false;
                        this.category.name = "";
                        this.$refs[name].resetFields();
                        return this.s("New category was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
        editCategoryModal(index, id, name) {
            this.editingCategoryModal = true;
            this.rowIndex = index;
            this.categoryId = id;
            this.category.name = name;
        },

        editCategory(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.categoryId, ...this.category };
                    const res = await this.callApi("post", "/edit_category", updatedData);
                    if (res.data.status === "success") {
                        await this.getCategories();
                        this.editingCategoryModal = false;
                        this.isEditing = false;
                        this.category.name = "";
                        this.$refs[name].resetFields();
                        return this.s("Category was updated successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        closeModal(name) {
            this.addingCategoryModal = false;
            this.editingCategoryModal = false;
            this.deleteCategoryModal = false;
            this.viewCategoryModal = false;
            this.$refs[name].resetFields();
        },
    },
};
</script>
