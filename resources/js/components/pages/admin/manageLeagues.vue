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
                                    <Button @click="addingLeagueModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add League
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
                                        <li class="active">Leagues</li>
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
                                            <Col span="20" offset="1" class="p-4 m-4">
                                            <Select v-model="leagueFilter" placeholder="Filter by League Name" filterable>
                                                <Option value="">All Leagues</Option>
                                                <Option v-for="(league, i) in leagues" :key="i" :value="league.league">{{ league.league
                                                }}</Option>
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
                                                    <th width="10%">ID</th>
                                                    <th width="10%">Logo</th>
                                                    <th width="50%">League</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(league, i) in newDatas" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td> <img style="object-fit: cover; width: 30px;"
                                                            :src="`${url_api}uploads/league/logo/${league.logo}`"
                                                            class="img-fluid" />
                                                    </td>
                                                    <td>
                                                        <Tag :color="leagueColor(i)" type="border">{{ league.league }}
                                                        </Tag>
                                                    </td>
                                                    <td>
                                                        <Button @click="viewLeague(league.league, league.logo)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button
                                                            @click="editLeagueModal(i, league.id, league.league, league.logo)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteLeague(league.id, league.league, league.logo)">
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

        <Modal v-model="deleteLeagueModal" title="View League" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ leagueName }}</i> league?</strong></p>
                <p>This action cannot be undone. Once deleted, the league will be permanently removed with their related
                    teams.</p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteLeague()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateLeagueForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewLeagueModal" title="View League" width="30%" class="text-center">
            <template>
                <div><img style="object-fit: cover; width: 30px;" :src="`${url_api}uploads/league/logo/${league.logo}`"
                        class="img-fluid" /></div>
                <Tag :color="leagueColor(1)" type="border">{{ leagueName }}</Tag>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateLeagueForm')" type="success">
                    <Icon type="ios-done-all" size="18" />
                    Ok
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingLeagueModal" title="Add League" width="30%">
            <template>
                <Form ref="validateLeagueForm" :model="league" :rules="validateLeague">
                    <Row>
                        <Col span="24">
                        <FormItem label="League Name" prop="league">
                            <Input v-model="league.league" type="text" placeholder="EPL"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <template>
                            <Upload action="/upload_league_logo" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag league logo here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <Col span="24" v-if="league.logo">
                        <img style="object-fit: cover; width: 100%;" :src="`${url_api}uploads/league/logo/${league.logo}`"
                            class="img-fluid" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateLeagueForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addLeague('validateLeagueForm')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingLeagueModal" title="Edit League" width="30%">
            <template>
                <Form ref="validateEditLeagueForm" :model="league" :rules="validateLeague">
                    <Row>
                        <Col span="24">
                        <FormItem label="League Name" prop="title">
                            <Input v-model="league.league" type="text" placeholder="Tech"></Input>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <template>
                            <Upload action="/upload_league_logo" type="drag" :headers="{ 'x-csrf-token': token }"
                                :on-success="handleSuccess" :format="['png', 'jpg', 'jpeg']"
                                :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize" :max-size="2048">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff" />
                                    <p>Click or drag league logo here to upload</p>
                                </div>
                            </Upload>
                        </template>
                        </Col>
                        <Col span="24" v-if="league.logo">
                        <img style="object-fit: cover; width: 100%;" :src="`${url_api}uploads/league/logo/${league.logo}`"
                            class="img-fluid" />
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateEditLeagueForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editLeague('validateEditLeagueForm')" type="primary" :disabled="isSaving"
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
            addingLeagueModal: false,
            editingLeagueModal: false,
            deleteLeagueModal: false,
            viewLeagueModal: false,
            isSaving: false,
            leagues: [],
            textLeague: [],
            tableLoading: true,
            keyword: "",
            leagueFilter: "",
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            leagueName: "",
            deleteImageDetail: "",
            leagueId: "",
            league: { league: "", logo: "" },

            validateLeague: {
                league: [
                    {
                        required: true,
                        message: "League name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
            validateUpdateLeague: {
                league: [
                    {
                        required: true,
                        message: "League name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            columns: [
                { title: "ID", slot: "number", sortable: true },
                { title: "League Name", slot: "name", align: "center" },
                { title: "Action", slot: "action", align: "center" },
            ],
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getLeagues();
    },

    computed: {
          // Apply filters to the Teams
          newDatas() {
            let filteredLeague = this.leagues;

            // Apply Team filter
            if (this.leagueFilter) {
                filteredLeague = filteredLeague.filter(league => {
                    return (
                        league.league.toLowerCase().includes(this.leagueFilter.toLowerCase())
                    );
                });
            }

            return filteredLeague;
        }
    },

    methods: {
        async handleSuccess(response, file) {
            if (this.deleteImageDetail) {
                var path = this.url_api + "uploads/league/logo/" + this.deleteImageDetail;
                const res = await this.callApi("post", "/delete_images", { path: path });
                if (res.data.success == 1) {
                    console.log("image removed");
                } else {
                    console.log("image was not deleted in the server");
                }
            }
            this.league.logo = response;
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

        async confirmDeleteLeague() {
            this.isSaving = true;
            var data = { id: this.leagueId };
            const res = await this.callApi("post", "/delete_league", data);
            if (res.data.status_code === 200) {
                if (this.deleteImageDetail) {
                    this.handleSuccess()
                }
                this.getLeagues();
                this.deleteLeagueModal = false;
                this.isSaving = false;
                this.leagueId = "";
                return this.s("League was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteLeague(id, league, logo) {
            this.deleteLeagueModal = true;
            this.leagueName = league;
            this.leagueId = id;
            if (logo) {
                this.deleteImageDetail = logo
            } else {
                this.deleteImageDetail = ""
            }
        },
        viewLeague(league, logo) {
            this.viewLeagueModal = true;
            this.leagueName = league;
            this.league.logo = logo;
        },
        leagueColor(index) {
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

        async getLeagues() {
            const res = await this.callApi("get", "/get_leagues");
            if (res.data.status === "success") {
                this.leagues = res.data.data;
                this.tableLoading = false;
            } else {
                this.leagues = [];
            }
        },

        addLeague(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_league", this.league);
                    if (res.data.status_code === 201) {
                        this.getLeagues();
                        this.addingLeagueModal = false;
                        this.isSaving = false;
                        this.league.league = "";
                        this.league.logo = "";
                        this.$refs[name].resetFields();
                        return this.s("New league was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
        editLeagueModal(index, id, name, logo) {
            this.editingLeagueModal = true;
            this.rowIndex = index;
            this.leagueId = id;
            this.league.league = name;
            if (logo) {
                this.league.logo = logo;
                this.deleteImageDetail = logo;
            } else {
                this.league.logo = "";
            }
        },

        editLeague(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.leagueId, ...this.league };
                    const res = await this.callApi("post", "/edit_league", updatedData);
                    if (res.data.status === "success") {
                        await this.getLeagues();
                        this.editingLeagueModal = false;
                        this.isEditing = false;
                        this.league.league = "";
                        this.league.logo = "";
                        this.$refs[name].resetFields();
                        return this.s("League was updated successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        closeModal(name) {
            this.addingLeagueModal = false;
            this.editingLeagueModal = false;
            this.deleteLeagueModal = false;
            this.viewLeagueModal = false;
            this.league.league = '';
            this.league.logo = '';
            this.$refs[name].resetFields();
        },
    },
};
</script>
