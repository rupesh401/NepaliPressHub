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
                                    <Button @click="addingAdsModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add New Ad
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
                                        <li class="active">Ads</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <template>
                                    <Form>
                                        <Row>
                                            <Col span="8" class="p-4 m-4">
                                            <Select v-model="positionFilter" placeholder="Filter by Position" filterable>
                                                <Option value="">All Position</Option>
                                                <Option value="sidebar">Sidebar</Option>
                                                <Option value="sidebar-home">Sidebar Home</Option>
                                                <Option value="home-between">Home Between</Option>
                                                <Option value="navbar">Navbar</Option>
                                                <Option value="footer">Footer</Option>
                                            </Select>
                                            </Col>
                                            <Col span="8" class="p-4 m-4">
                                            <Select v-model="provinceFilter" placeholder="Filter by Province" filterable>
                                                <Option value="">All Provinces</Option>
                                                <Option v-for="(prov, i) in provinces" :key="i" :value="prov.province">{{
                                                    prov.province }}</Option>
                                            </Select>
                                            </Col>
                                            <Col span="8" class="p-4 m-4">
                                            <Select v-model="statusFilter" placeholder="Filter by Status" filterable>
                                                <Option value="">All Status</Option>
                                                <Option value="active">Active</Option>
                                                <Option value="inactive">Inactive</Option>
                                            </Select>
                                            </Col>
                                        </Row>
                                    </Form>
                                </template>
                                <div class="card alert">
                                    <div class="order-list-item">
                                        <table class="table item-center">
                                            <thead class="content-center">
                                                <tr>
                                                    <th width="5%">ID</th>
                                                    <th width="15%">Picture</th>
                                                    <th width="20%">Position</th>
                                                    <th width="20%">Province</th>
                                                    <th width="10%">Status</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ad, i) in newDatas" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>
                                                        <template>
                                                            <img v-if="ad.image" class="img-fluid" width="60"
                                                                style="border-radius: 10%"
                                                                :src="`${url_api}uploads/ads/${ad.image}`" alt="Ad Image" />
                                                            <img class="img-fluid" width="60" style="border-radius: 10%"
                                                                v-else src="uploads/ads/default.png" alt="Ad Image" />
                                                        </template>
                                                    </td>
                                                    <td> {{ ad.position }}</td>
                                                    <td v-if="ad.prv.length > 0">{{ ad.prv[0].province }}</td>
                                                    <td v-else>No Province</td>
                                                    <td>
                                                        <Button v-if="ad.status === 'Active'" type="success" size="small">
                                                            {{ ad.status }}
                                                        </Button>
                                                        <Button v-else type="error" size="small">
                                                            {{ ad.status }}
                                                        </Button>
                                                    </td>
                                                    <td>
                                                        <i-switch @on-change="
                                                            updateStatus(
                                                                ad.id,
                                                                ad.status != 'Active' ? 'Inactive' : 'Active'
                                                            )
                                                            " v-model="ad.status" true-value="Active"
                                                            false-value="Inactive" true-color="#13ce66"
                                                            false-color="#ff4949" size="small" />
                                                        <Button size="small"
                                                            @click="viewAdModal(i, ad.id, ad.position, ad.image, ad.prv, ad.link)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button size="small"
                                                            @click=" editAdModal(i, ad.id, ad.position, ad.image, ad.prv, ad.link)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button size="small" v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteAd(ad.id, ad.image)">
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

        <Modal v-model="deleteAdModal" title="Delete Ad" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ adName }}</i> ad?</strong></p>
                <p><strong>This action cannot be undone. Once deleted, the ad will be permanently removed.</strong></p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteAd()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateAdForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>

        <Modal v-model="viewingAdsModal" :title="ad.position + ' - Ad '" width="40%">
            <template>
                <div class="text-center">
                    <br>
                    <div class="ad-img">
                        <img :src="`${url_api}uploads/ads/${ad.image}`" class="rounded-circle" alt="profile-image"
                            width="400px" style="object-fit: cover; border-radius: 20px;" />
                    </div>
                    <br />
                    <p v-if="ad.province != ''" style="text-align: center;">{{ province_name }}</p>
                    <p style="text-align: center;">{{ ad.link }}</p>
                </div>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Close
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingAdsModal" title="Add Ad" width="40%">
            <template>
                <Form ref="addFormValidation" :model="ad" :rules="ruleValidate">
                    <p v-if="ad.position == 'sidebar' || ad.position == 'sidebar-home'" style="color: red; text-align: center;">Ads Height should be 283px and Width 255px</p>
                    <p v-if="ad.position == 'home-between'" style="color: red; text-align: center;">Ads Height should be 100px and Width 825px</p>
                    <p v-if="ad.position == 'navbar'" style="color: red; text-align: center;">Ads Height should be 90px and Width 730px</p>
                    <p v-if="ad.position == 'footer'" style="color: red; text-align: center;">Ads Height should be 90px and Width 680px</p>
                    <Row>
                        <Col v-if="ad.position === 'sidebar'" span="11">
                        <FormItem label="Position" prop="position">
                            <Select v-model="ad.position" filterable>
                                <Option value="sidebar">Sidebar</Option>
                                <Option value="sidebar-home">Sidebar Home</Option>
                                <Option value="home-between">Home Between</Option>
                                <Option value="navbar">Navbar</Option>
                                <Option value="footer">Footer</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col v-if="ad.position != 'sidebar'" span="21" offset="1">
                        <FormItem label="Position" prop="position">
                            <Select v-model="ad.position" filterable>
                                <Option value="sidebar">Sidebar</Option>
                                <Option value="sidebar-home">Sidebar Home</Option>
                                <Option value="home-between">Home Between</Option>
                                <Option value="navbar">Navbar</Option>
                                <Option value="footer">Footer</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col v-if="ad.position === 'sidebar'" span="11" offset="1">
                        <FormItem label="Province" prop="province">
                            <Select v-model="ad.province" filterable>
                                <Option v-for="(prov, i) in provinces" :key="i" :value="prov.id">{{
                                    prov.province
                                }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="21" offset="1">
                        <FormItem label="Ads Link" prop="link">
                            <Input v-model="ad.link" type="text" placeholder="Write ads link here"></Input>
                        </FormItem>
                        </Col>
                        <Col span="21" offset="1">
                        <template>
                            <Upload action="/upload_ads_image" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg', 'gif']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag ads here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <Col span="24" v-if="ad.image">
                        <img style="object-fit: cover; width: 100%;" :src="`${url_api}uploads/ads/${ad.image}`"
                            class="img-fluid" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('addFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addNewAd('addFormValidation')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingModal" title="Edit Ad Info" width="40%">
            <template>
                <Form ref="editFormValidation" :model="ad" :rules="ruleValidate">
                    <p v-if="ad.position == 'sidebar' || ad.position == 'sidebar-home'" style="color: red; text-align: center;">Ads Height should be 283px and Width 255px</p>
                    <p v-if="ad.position == 'home-between'" style="color: red; text-align: center;">Ads Height should be 100px and Width 825px</p>
                    <p v-if="ad.position == 'navbar'" style="color: red; text-align: center;">Ads Height should be 90px and Width 730px</p>
                    <p v-if="ad.position == 'footer'" style="color: red; text-align: center;">Ads Height should be 90px and Width 680px</p>
                    <Row>
                        <Col v-if="ad.position === 'sidebar'" span="11">
                        <FormItem label="Position" prop="position">
                            <Select v-model="ad.position" filterable>
                                <Option value="sidebar">Sidebar</Option>
                                <Option value="sidebar-home">Sidebar Home</Option>
                                <Option value="home-between">Home Between</Option>
                                <Option value="navbar">Navbar</Option>
                                <Option value="footer">Footer</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col v-if="ad.position != 'sidebar'" span="21" offset="1">
                        <FormItem label="Position" prop="position">
                            <Select v-model="ad.position" filterable>
                                <Option value="sidebar">Sidebar</Option>
                                <Option value="sidebar-home">Sidebar Home</Option>
                                <Option value="home-between">Home Between</Option>
                                <Option value="navbar">Navbar</Option>
                                <Option value="footer">Footer</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col v-if="ad.position === 'sidebar'" span="11" offset="1">
                        <FormItem label="Province" prop="province">
                            <Select v-model="ad.province" filterable>
                                <Option v-for="(prov, i) in provinces" :key="i" :value="prov.id">{{
                                    prov.province
                                }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="21" offset="1">
                        <FormItem label="Ads Link" prop="link">
                            <Input v-model="ad.link" type="text" placeholder="Write ads link here"></Input>
                        </FormItem>
                        </Col>
                        <Col span="21" offset="1">
                        <template>
                            <Upload action="/upload_ads_image" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg', 'gif']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag ads here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <Col span="24" v-if="ad.image">
                        <img style="object-fit: cover; width: 100%;" :src="`${url_api}uploads/ads/${ad.image}`"
                            class="img-fluid" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('editFormValidation')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editAd('editFormValidation')" type="primary" :disabled="isEditing" :loading="isEditing">
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
export default {
    components: { Navbar, Leftbar, Footer },
    data() {
        return {
            addingAdsModal: false,
            viewingAdsModal: false,
            deleteAdModal: false,
            isSaving: false,
            deleteImageDetail: "",
            ads: [],
            filteredAds: [],
            positionFilter: "",
            provinceFilter: "",
            statusFilter: "",
            provinces: [],
            province_name: '',
            tableLoading: true,
            keyword: "",
            editingModal: false,
            isEditing: false,
            adsId: "",
            adName: "",
            rowIndex: "",
            status: "",
            token: "",
            ad: { position: "sidebar", province: "", image: "", link: "" },

            ruleValidate: {
                title: [
                    {
                        required: true,
                        message: "Title field cannot be empty.",
                        trigger: "blur",
                    },
                ],
                link: [
                    {
                        required: true,
                        message: "Link cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            updateRuleValidate: {
                title: [
                    {
                        required: true,
                        message: "Title field cannot be empty.",
                        trigger: "blur",
                    },
                ],
                link: [
                    {
                        required: true,
                        message: "Link cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getAds();
        await this.getProvinces();
    },
    computed: {
        // Apply filters to the Ads
        newDatas() {
            let filteredAds = this.ads;

            // Apply Position filter
            if (this.positionFilter) {
                filteredAds = filteredAds.filter(ads => {
                    return (
                        (this.positionFilter === "sidebar" && ads.position === "sidebar") ||
                        (this.positionFilter === "navbar" && ads.position === "navbar") ||
                        (this.positionFilter === "sidebar-home" && ads.position === "sidebar-home") ||
                        (this.positionFilter === "home-between" && ads.position === "home-between")
                    );
                });
            }

            // Apply province filter
            if (this.provinceFilter) {
                filteredAds = filteredAds.filter(ads => {
                    if (ads.prv && ads.prv.length > 0) {
                        return ads.prv[0].province.toLowerCase().includes(this.provinceFilter.toLowerCase());
                    } else {
                        return false; // Exclude adss without valid province information
                    }
                });
            }

            // Apply status filter
            if (this.statusFilter) {
                filteredAds = filteredAds.filter(ads => {
                    const status = ads.status.toLowerCase();
                    // console.log(status);
                    return (
                        (this.statusFilter === "active" && status === "active") ||
                        (this.statusFilter === "inactive" && status === "inactive")
                    );
                });
            }
            return filteredAds;
        }
    },

    methods: {

        async getProvinces() {
            const res = await this.callApi("get", "/get_provinces");
            if (res.data.status === "success") {
                this.provinces = res.data.data;
            } else {
                this.provinces = [];
            }
        },

        async confirmDeleteAd() {
            this.isSaving = true;
            var data = { id: this.adsId };
            const res = await this.callApi("post", "/delete_ads", data);
            if (res.data.status_code === 200) {
                if (this.deleteImageDetail) {
                   this.handleSuccess()
                }
                this.getAds();
                this.deleteAdModal = false;
                this.isSaving = false;
                this.adsId = "";
                return this.s("Ads was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteAd(id, image) {
            this.deleteAdModal = true;
            this.adsId = id;
            if(image) {
                this.deleteImageDetail = image
            } else {
                this.deleteImageDetail = ""
            }
        },

        truncate(text, length) {
            if (text.length <= length) {
                return text;
            } else {
                return text.slice(0, length) + "...";
            }
        },
        async handleSuccess(response, file) {
            if (this.deleteImageDetail) {
                var path = this.url_api + "uploads/ads/" + this.deleteImageDetail;
                const res = await this.callApi("post", "/delete_images", { path: path });
                if (res.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            this.ad.image = response;
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

        async getAds() {
            const res = await this.callApi("get", "/get_ads");
            if (res.data.status === "success") {
                this.ads = res.data.data;
                this.tableLoading = false;
            } else {
                this.ads = [];
                this.tableLoading = false;
            }
        },

        addNewAd(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_ads", this.ad);
                    if (res.data.status_code === 201) {
                        this.getAds();
                        this.addingAdsModal = false;
                        this.isSaving = false;
                        this.ad.image = "";
                        this.ad.position = "";
                        this.ad.link = "";
                        this.ad.province = "";
                        this.$refs[name].resetFields();
                        return this.s("New ads was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        viewAdModal(i, id, position, image, province, link) {
            this.viewingAdsModal = true;
            this.rowIndex = i;
            this.adsId = id;
            this.ad.position = position;
            this.ad.link = link;
            if (province.length > 0) {
                this.ad.province = province[0].id;
                this.province_name = province[0].province;

            } else {
                this.ad.province = '';
            }
            if (image) {
                this.ad.image = image;
            } else {
                this.ad.image = "";
            }
        },
        editAdModal(i, id, position, image, province, link) {
            this.editingModal = true;
            this.rowIndex = i;
            this.adsId = id;
            this.ad.position = position;
            this.ad.link = link;

            if (province.length > 0) {
                this.ad.province = province[0].id;

            } else {
                this.ad.province = '';
            }
            if (image) {
                this.ad.image = image;
                this.deleteImageDetail = image;
            } else {
                this.ad.image = "";
            }
        },

        editAd(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.adsId, ...this.ad };
                    const res = await this.callApi("post", "/edit_ads", updatedData);
                    if (res.data.status === "success") {
                        await this.getAds();
                        this.editingModal = false;
                        this.isEditing = false;
                        this.ad.image = ""
                        this.ad.position = ""
                        this.ad.province = ""
                        this.ad.link = ""
                        this.adsId = ""
                        this.$refs[name].resetFields();
                        return this.s("Ads infos wa updated successfully");
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
            const res = await this.callApi("post", "/edit_ads", updatedData);
            if (res.data.status === "success") {
                await this.getAds();
            }
        },

        closeModal(name) {
            this.addingAdsModal = false
            this.editingModal = false
            this.viewingAdsModal = false
            this.deleteAdModal = false
            this.ad.link = ""
            // this.ad.image = ""
            this.ad.position = ""
            this.ad.province = ""
            this.adsId = ""

            // this.$refs[name].resetFields();
        },
    },
};
</script>
