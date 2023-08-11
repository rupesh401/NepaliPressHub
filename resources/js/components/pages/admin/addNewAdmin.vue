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
                                        Add New Admin
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
                                        <li class="active">Admins</li>
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
                                                    <th width="25%">Full Name</th>
                                                    <th width="25%">Email</th>
                                                    <th width="15%">Phone Number</th>
                                                    <th width="25%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(admin, i) in admins" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>{{ admin.full_name }}</td>
                                                    <td>{{ admin.email }}</td>
                                                    <td>{{ admin.phone_number }}</td>
                                                    <td>
                                                        <i-switch v-if="$store.state.userInfos.id != admin.id" @on-change="
                                                            updateStatus(admin.id, admin.status != 'Active' ? 'Blocked' : 'Active')"
                                                            v-model="admin.status" true-value="Active" false-value="Blocked"
                                                            true-color="#13ce66" false-color="#ff4949" />
                                                        <!-- <Button @click="viewTag(tag.tag)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button> -->
                                                        <Button
                                                            @click=" editSuperUserModal(i, admin.id, admin.full_name, admin.email, admin.phone_number)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1 && $store.state.userInfos.id != admin.id"
                                                            @click="deleteAdmin(admin.id, admin.full_name)">
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

        <Modal v-model="deleteAdminModal" title="Delete Admin" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ adminName }}</i> admin?</strong></p>
                <p><strong>This action cannot be undone. Once deleted, the admin will be permanently removed.</strong></p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteAdmin()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateTagForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingModal" title="Add New Admin" width="40%">
            <template>
                <Form ref="addFormValidation" :model="admin" :rules="ruleValidate">
                    <Row>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Full Name" prop="full_name">
                            <Input v-model="admin.full_name" type="text" placeholder="Ferdinand Mwitumba"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Email Address" prop="email_address">
                            <Input v-model="admin.email_address" type="email" placeholder="example@mail.com"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Phone Number" prop="phone_number">
                            <Input v-model="admin.phone_number" type="tel" placeholder="+255 768 543 991"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Password" prop="password">
                            <Input v-model="admin.password" type="password" placeholder="**********"></Input>
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
                <Button @click="addSuperUser('addFormValidation')" type="primary" :disabled="isAdding" :loading="isAdding">
                    <Icon type="md-document" size="18" />
                    {{ isAdding ? "Adding..." : "Add" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingModal" title="Edit Admin Info" width="40%">
            <template>
                <Form ref="editFormValidation" :model="admin" :rules="updateRuleValidate">
                    <Row>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Full Name" prop="full_name">
                            <Input v-model="admin.full_name" type="text" placeholder="Ferdinand Mwitumba"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Email Address" prop="email_address">
                            <Input v-model="admin.email_address" type="email" placeholder="example@mail.com"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Phone Number" prop="phone_number">
                            <Input v-model="admin.phone_number" type="tel" placeholder="+255 768 543 991"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24" class="m-1">
                        <FormItem class="m-1" label="Password" prop="password">
                            <Input v-model="admin.password" type="password" placeholder="**********"></Input>
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
                <Button @click="editSuperUser('editFormValidation')" type="primary" :disabled="isEditing"
                    :loading="isEditing">
                    <Icon type="md-document" size="18" />
                    {{ isEditing ? "Updating..." : "Update" }}
                </Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import Navbar from "../../inc/navbar.vue";
import Leftbar from "../../inc/leftbar.vue";
export default {
    components: { Navbar, Leftbar },
    data() {
        return {
            addingModal: false,
            deleteAdminModal: false,
            isAdding: false,
            admins: [],
            tableLoading: true,
            keyword: "",
            editingModal: false,
            isEditing: false,
            adminId: "",
            adminName: "",
            rowIndex: "",
            status: "",
            admin: {
                full_name: "",
                email_address: "",
                phone_number: "",
                password: "",
            },

            ruleValidate: {
                full_name: [
                    {
                        required: true,
                        message: "Full name field cannot be empty!",
                        trigger: "blur",
                    },
                ],
                email_address: [
                    { required: true, message: "Mailbox cannot be empty!", trigger: "blur" },
                    { type: "email", message: "Incorrect email format", trigger: "blur" },
                ],
                phone_number: [
                    { required: true, message: "Phone number cannot be empty!", trigger: "blur" },
                ],
                password: [
                    { required: true, message: "Password cannot be empty!", trigger: "blur" },
                ],
            },

            updateRuleValidate: {
                full_name: [
                    {
                        required: true,
                        message: "Full name field cannot be empty!",
                        trigger: "blur",
                    },
                ],
                email_address: [
                    { required: true, message: "Mailbox cannot be empty!", trigger: "blur" },
                    { type: "email", message: "Incorrect email format", trigger: "blur" },
                ],

                phone_number: [
                    { required: true, message: "Phone number cannot be empty!", trigger: "blur" },
                ],
            },

            columns: [
                { title: "Name", key: "full_name", sortable: true },
                { title: "Email", key: "email" },
                { title: "Phone Number", key: "phone_number" },
                { title: "Status", key: "status", sortable: true },
                { title: "Action", slot: "action", align: "center" },
            ],
        };
    },

    async created() {
        await this.getSuperAdmins();
    },

    methods: {

        async confirmDeleteAdmin() {
            this.isSaving = true;
            var data = {id: this.adminId };
            const res = await this.callApi("post", "/delete_admin_user", data);
            if (res.data.status_code === 200) {
                this.getSuperAdmins();
                this.deleteAdminModal = false;
                this.isSaving = false;
                this.adminId = "";
                return this.s("Admin was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteAdmin(id, full_name) {
            this.deleteAdminModal = true;
            this.adminName = full_name;
            this.adminId = id;
        },

        async getSuperAdmins() {
            const res = await this.callApi("get", "/get_admins");
            if (res.data.status === "success") {
                this.admins = res.data.data;
                this.tableLoading = false;
            } else {
                this.admins = [];
                this.tableLoading = false;
            }
        },

        addSuperUser(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isAdding = true;
                    const res = await this.callApi("post", "/add_new_admin", this.admin);
                    if (res.data.status_code === 201) {
                        await this.getSuperAdmins();
                        this.addingModal = false;
                        this.isAdding = false;
                        this.$refs[name].resetFields();
                        return this.s(res.data.data.full_name + " was added successfully as admin");
                    } else {
                        this.isAdding = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        editSuperUserModal(index, id, full_name, email, phone_number) {
            this.editingModal = true;
            this.rowIndex = index;
            this.adminId = id;
            this.admin.full_name = full_name;
            this.admin.email_address = email;
            this.admin.phone_number = phone_number;
        },

        editSuperUser(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.adminId, ...this.admin };
                    const res = await this.callApi("post", "/edit_admin", updatedData);
                    if (res.data.status === "success") {
                        await this.getSuperAdmins();
                        this.editingModal = false;
                        this.isEditing = false;
                        this.$refs[name].resetFields();
                        return this.s(res.data.data.full_name + " info was updated successfully");
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
            const res = await this.callApi("post", "/edit_admin", updatedData);
            if (res.data.status === "success") {
                await this.getSuperAdmins();
            }
        },

        searchSuperAdmin() {
            console.log(this.keyword);
            return this.admins.filter((object) => {
                return (
                    object.full_name.toLowerCase().includes(this.keyword.toLowerCase()) ||
                    object.email.toLowerCase().includes(this.keyword.toLowerCase()) ||
                    object.phone_number.toLowerCase().includes(this.keyword.toLowerCase())
                );
            });
        },

        closeModal(name) {
            (this.addingModal = false),
            (this.deleteAdminModal = false),
                (this.editingModal = false),
                this.$refs[name].resetFields();
        },
    },
};
</script>
