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
                                        <li class="active">Contacts</li>
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
                                                <div :class="{ 'col-lg-8 col-md-8 col-sm-12 col-xs-12 offset-lg-2 offset-md-2': hideContact, 'col-lg-6 col-md-6 col-sm-6': !hideContact }">
                                                    <template>
                                                        <Form ref="addFormValidation" :model="contact"
                                                            :rules="ruleValidate">
                                                            <Row>
                                                                <Col span="11">
                                                                <FormItem label="Phone Number" prop="phone_number">
                                                                    <Input :readonly="inputDisable"
                                                                        v-model="contact.phone_number" type="text"
                                                                        placeholder="+1 768 543 991"></Input>
                                                                </FormItem>
                                                                </Col>
                                                                <Col span="11" offset="1">
                                                                <FormItem label="Email" prop="email">
                                                                    <Input :readonly="inputDisable" v-model="contact.email"
                                                                        type="text" placeholder="rupesh@gmail.com"></Input>
                                                                </FormItem>
                                                                </Col>
                                                                <!-- <Col span="23">
                                                                <FormItem label="Postal Address" prop="address">
                                                                    <Input :readonly="inputDisable"
                                                                        v-model="contact.address" type="text"
                                                                        placeholder="179 Mbeya"></Input>
                                                                </FormItem>
                                                                </Col> -->
                                                                <!-- <Col span="23">
                                                                <FormItem label="Visit Address" prop="visit_address">
                                                                    <Input :readonly="inputDisable"
                                                                        v-model="contact.visit_address" type="textarea"
                                                                        placeholder="179 Mbeya"></Input>
                                                                </FormItem>
                                                                </Col> -->
                                                                <Col span="11">
                                                                <FormItem label="Twitter Account" prop="twitter">
                                                                    <Input :readonly="inputDisable"
                                                                        v-model="contact.twitter" type="text"
                                                                        placeholder=""></Input>
                                                                </FormItem>
                                                                </Col>
                                                                <Col span="11" offset="1">
                                                                <FormItem label="Facebook Account" prop="facebook">
                                                                    <Input :readonly="inputDisable"
                                                                        v-model="contact.facebook" type="text"
                                                                        placeholder=""></Input>
                                                                </FormItem>
                                                                </Col>
                                                                <Col span="11">
                                                                <FormItem label="Instagram Account" prop="instagram">
                                                                    <Input :readonly="inputDisable"
                                                                        v-model="contact.instagram" type="text"
                                                                        placeholder=""></Input>
                                                                </FormItem>
                                                                </Col>
                                                                <Col span="11" offset="1">
                                                                <FormItem label="Youtube Account" prop="youtube">
                                                                    <Input :readonly="inputDisable"
                                                                        v-model="contact.youtube" type="text"
                                                                        placeholder=""></Input>
                                                                </FormItem>
                                                                </Col>
                                                                <Col span="23">
                                                                <Button @click="addContact('addFormValidation')"
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
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="body">
                                                        <div v-if="hideContact == false"
                                                            class="table-responsive social_media_table">
                                                            <table class="table table-hover">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <span class="social_icon linkedin"
                                                                                style="background-color: green"><i
                                                                                    class="zmdi zmdi-account-box-phone"></i></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="list-name">Phone Number</span>
                                                                        </td>
                                                                        <td>{{ contact.phone_number }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span class="social_icon linkedin"
                                                                                style="background-color: orange"><i
                                                                                    class="zmdi zmdi-email"></i></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="list-name">Email</span>
                                                                        </td>
                                                                        <td>{{ contact.email }}</td>
                                                                    </tr>
                                                                    <tr v-if="contact.whatsapp">
                                                                        <td>
                                                                            <span class="social_icon whatsapp"
                                                                                style="background-color: #2ef034"><i
                                                                                    class="zmdi zmdi-whatsapp"></i></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="list-name">Whatsapp Account</span>
                                                                        </td>
                                                                        <td>{{ contact.whatsapp }}</td>
                                                                    </tr>
                                                                    <tr v-if="contact.twitter">
                                                                        <td>
                                                                            <span class="social_icon linkedin"
                                                                                style="background-color: #159ff0"><i
                                                                                    class="zmdi zmdi-twitter"></i></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="list-name">Twitter Account</span>
                                                                        </td>
                                                                        <td>{{ contact.twitter }}</td>
                                                                    </tr>
                                                                    <tr v-if="contact.facebook">
                                                                        <td>
                                                                            <span class="social_icon linkedin"
                                                                                style="background-color: #186ef0"><i
                                                                                    class="zmdi zmdi-facebook"></i></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="list-name">Facebook Account</span>
                                                                        </td>
                                                                        <td>{{ contact.facebook }}</td>
                                                                    </tr>
                                                                    <tr v-if="contact.instagram">
                                                                        <td>
                                                                            <span class="social_icon linkedin"
                                                                                style="background-color: #c11c8c"><i
                                                                                    class="zmdi zmdi-instagram"></i></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="list-name">Instagram Account</span>
                                                                        </td>
                                                                        <td>{{ contact.instagram }}</td>
                                                                    </tr>
                                                                    <tr v-if="contact.youtube">
                                                                        <td>
                                                                            <span class="social_icon youtube"><i
                                                                                    class="zmdi zmdi-youtube"></i></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="list-name">Youtube Account</span>
                                                                        </td>
                                                                        <td>{{ contact.youtube }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <br />
                                                            <Col span="22" offset="1">
                                                            <Button @click="(inputDisable = false), (hideContact = true)"
                                                                type="primary" :loading="isSaving" long ghost size="large">
                                                                <Icon size="18" />
                                                                Edit
                                                            </Button>
                                                            </Col>
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
export default {
    components: { Navbar, Leftbar, Footer },
    data() {
        return {
            inputDisable: false,
            hideContact: false,
            isSaving: false,
            contacts: [],
            tableLoading: true,
            keyword: "",
            editingModal: false,
            isEditing: false,
            contactId: "",
            rowIndex: "",
            status: "",
            token: "",
            contact: {
                id: "",
                phone_number: "",
                email: "",
                address: "",
                visit_address: "",
                twitter: "",
                facebook: "",
                instagram: "",
                youtube: "",
            },

            ruleValidate: {
                phone_number: [
                    {
                        required: true,
                        message: "Phone number cannot be empty.",
                        trigger: "blur",
                    },
                ],
                email: [
                    {
                        required: true,
                        message: "Email cannot be empty.",
                        trigger: "blur",
                    },
                ],
                // address: [
                //     {
                //         required: true,
                //         message: "Postal address cannot be empty.",
                //         trigger: "blur",
                //     },
                // ],
                // visit_address: [
                //     {
                //         required: true,
                //         message: "Visit address cannot be empty.",
                //         trigger: "blur",
                //     },
                // ],
            },
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getContacts();
    },

    methods: {
        async getContacts() {
            const res = await this.callApi("get", "/get_contact");
            if (res.data.data) {
                var contacts = res.data.data;
                this.contact.id = contacts[0].id;
                this.contact.phone_number = contacts[0].phone_number;
                this.contact.email = contacts[0].email;
                // this.contact.address = contacts[0].address;
                // this.contact.visit_address = contacts[0].visit_address;
                this.contact.twitter = contacts[0].twitter;
                this.contact.facebook = contacts[0].facebook;
                this.contact.instagram = contacts[0].instagram;
                this.contact.youtube = contacts[0].youtube;
                this.inputDisable = true;
            } else {
            }
        },

        addContact(name) {
            if (this.hideContact) {
                this.editContact(name);
            } else {
                this.$refs[name].validate(async (valid) => {
                    if (valid) {
                        this.isSaving = true;
                        const res = await this.callApi("post", "/add_new_contact", this.contact);
                        if (res.data.status_code === 201) {
                            this.getContacts();
                            this.hideContact = false;
                            this.isSaving = false;
                            this.$refs[name].resetFields();
                            return this.s("New contact was added successfully");
                        } else {
                            this.isSaving = false;
                            return this.swr();
                        }
                    } else {
                    }
                });
            }
        },

        editContact(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    const res = await this.callApi("post", "/edit_contact", this.contact);
                    if (res.data.status === "success") {
                        await this.getContacts();
                        this.hideContact = false;
                        this.isSaving = false;
                        return this.s("Contact infos wa updated successfully");
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
