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
                                <div class="card alert">
                                    <div class="order-list-item">
                                        <table class="table item-center">
                                            <thead class="content-center">
                                                <tr>
                                                    <th width="20%">ID</th>
                                                    <th width="50%">League</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(league, i) in leagues" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>
                                                        <Tag :color="leagueColor(i)" type="border">{{ league.league }}
                                                        </Tag>
                                                    </td>
                                                    <td>
                                                        <Button @click="viewLeague(league.league)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button @click="editLeagueModal(i, league.id, league.league)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteLeague(league.id, league.league)">
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
                <p>This action cannot be undone. Once deleted, the league will be permanently removed with their related teams.</p>
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
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateLeagueForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addLeague('validateLeagueForm')" type="primary" :disabled="isSaving"
                    :loading="isSaving">
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
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            leagueName: "",
            leagueId: "",
            league: { league: "" },

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

    computed: {},

    methods: {
        async confirmDeleteLeague() {
            this.isSaving = true;
            var data = { id: this.leagueId };
            const res = await this.callApi("post", "/delete_league", data);
            if (res.data.status_code === 200) {
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

        deleteLeague(id, league) {
            this.deleteLeagueModal = true;
            this.leagueName = league;
            this.leagueId = id;
        },
        viewLeague(league) {
            this.viewLeagueModal = true;
            this.leagueName = league;
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
        editLeagueModal(index, id, name) {
            this.editingLeagueModal = true;
            this.rowIndex = index;
            this.leagueId = id;
            this.league.league = name;
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
            this.$refs[name].resetFields();
        },
    },
};
</script>
