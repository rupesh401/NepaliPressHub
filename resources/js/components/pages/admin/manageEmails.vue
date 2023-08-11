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
                                    <Button @click="addingProvinceModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add Province
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
                                        <li class="active">Provinces</li>
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
                                                    <th width="50%">Province</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(province, i) in provinces" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>
                                                        <Tag :color="provinceColor(i)" type="border">{{ province.province }}
                                                        </Tag>
                                                    </td>
                                                    <td>
                                                        <Button @click="viewProvince(province.province)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button @click="editProvinceModal(i, province.id, province.province)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteProvince(province.id, province.province)">
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

        <Modal v-model="deleteProvinceModal" title="View Province" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ provinceName }}</i> province?</strong></p>
                <p>This action cannot be undone. Once deleted, the province will be permanently removed.</p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteProvince()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateProvinceForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewProvinceModal" title="View Province" width="30%" class="text-center">
            <template>
                <Tag :color="provinceColor(1)" type="border">{{ provinceName }}</Tag>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateProvinceForm')" type="success">
                    <Icon type="ios-done-all" size="18" />
                    Ok
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingProvinceModal" title="Add Province" width="30%">
            <template>
                <Form ref="validateProvinceForm" :model="province" :rules="validateProvince">
                    <Row>
                        <Col span="24">
                        <FormItem label="Province" prop="province">
                            <Input v-model="province.name" type="text" placeholder="Province"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateProvinceForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addProvince('validateProvinceForm')" type="primary" :disabled="isSaving"
                    :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingProvinceModal" title="Edit Province" width="30%">
            <template>
                <Form ref="validateEditProvinceForm" :model="province" :rules="validateProvince">
                    <Row>
                        <Col span="24">
                        <FormItem label="Post Title" prop="title">
                            <Input v-model="province.name" type="text" placeholder="Tech"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateEditProvinceForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editProvince('validateEditProvinceForm')" type="primary" :disabled="isSaving"
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
            addingProvinceModal: false,
            editingProvinceModal: false,
            deleteProvinceModal: false,
            viewProvinceModal: false,
            isSaving: false,
            provinces: [],
            textProvince: [],
            tableLoading: true,
            keyword: "",
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            provinceName: "",
            provinceId: "",
            province: { name: "" },

            validateProvince: {
                name: [
                    {
                        required: true,
                        message: "Province name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
            validateUpdateProvince: {
                name: [
                    {
                        required: true,
                        message: "Province name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            columns: [
                { title: "ID", slot: "number", sortable: true },
                { title: "Province Name", slot: "name", align: "center" },
                { title: "Action", slot: "action", align: "center" },
            ],
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getProvinces();
    },

    computed: {},

    methods: {
        async confirmDeleteProvince() {
            this.isSaving = true;
            var data = { id: this.provinceId };
            const res = await this.callApi("post", "/delete_province", data);
            if (res.data.status_code === 200) {
                this.getProvinces();
                this.deleteProvinceModal = false;
                this.isSaving = false;
                this.provinceId = "";
                return this.s("Province was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteProvince(id, province) {
            this.deleteProvinceModal = true;
            this.provinceName = province;
            this.provinceId = id;
        },
        viewProvince(province) {
            this.viewProvinceModal = true;
            this.provinceName = province;
        },
        provinceColor(index) {
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

        async getProvinces() {
            const res = await this.callApi("get", "/get_provinces");
            if (res.data.status === "success") {
                this.provinces = res.data.data;
                this.tableLoading = false;
            } else {
                this.provinces = [];
            }
        },

        addProvince(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_province", this.province);
                    if (res.data.status_code === 201) {
                        this.getProvinces();
                        this.addingProvinceModal = false;
                        this.isSaving = false;
                        this.province.name = "";
                        this.$refs[name].resetFields();
                        return this.s("New province was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
        editProvinceModal(index, id, name) {
            this.editingProvinceModal = true;
            this.rowIndex = index;
            this.provinceId = id;
            this.province.name = name;
        },

        editProvince(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.provinceId, ...this.province };
                    const res = await this.callApi("post", "/edit_province", updatedData);
                    if (res.data.status === "success") {
                        await this.getProvinces();
                        this.editingProvinceModal = false;
                        this.isEditing = false;
                        this.province.name = "";
                        this.$refs[name].resetFields();
                        return this.s("Province was updated successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        closeModal(name) {
            this.addingProvinceModal = false;
            this.editingProvinceModal = false;
            this.deleteProvinceModal = false;
            this.viewProvinceModal = false;
            this.$refs[name].resetFields();
        },
    },
};
</script>
