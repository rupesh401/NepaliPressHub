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
                                    <Button @click="addingTeamModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add Team
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
                                        <li class="active">Teams</li>
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
                                                    <th width="25%">League</th>
                                                    <th width="25%">Team</th>
                                                    <th width="30%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(team, i) in teams" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>
                                                        <Tag :color="teamColor(i)" type="border">{{ team.team }}
                                                        </Tag>
                                                    </td>
                                                    <td>
                                                        <Tag :color="teamColor(i)" type="border">{{ team.league[0].league }}
                                                        </Tag>
                                                    </td>
                                                    <td>
                                                        <Button @click="viewTeam(team.team, team.league[0].league)">
                                                            <Icon type="ios-eye-outline" color="blue" size="25" />
                                                        </Button>
                                                        <Button @click="editTeamModal(i, team.id, team.team, team.league[0].id)">
                                                            <Icon type="ios-create-outline" color="green" size="25" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteTeam(team.id, team.team)">
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

        <Modal v-model="deleteTeamModal" title="View Team" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ teamName }}</i> team?</strong></p>
                <p>This action cannot be undone. Once deleted, the team will be permanently removed.</p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteTeam()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal('validateTeamForm')" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewTeamModal" title="View Team" width="30%" class="text-center">
            <template>
                <p>League Name: <Tag :color="teamColor(1)" type="border">{{ team.league }}</Tag></p>
                <p>Team Name: <Tag :color="teamColor(1)" type="border">{{ teamName }}</Tag></p>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateTeamForm')" type="success">
                    <Icon type="ios-done-all" size="18" />
                    Ok
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingTeamModal" title="Add Team" width="30%">
            <template>
                <Form ref="validateTeamForm" :model="team" :rules="validateTeam">
                    <Row>
                        <Col span="24">
                        <FormItem label="League" prop="league">
                            <Select v-model="team.league" placeholder="Please Select League" filterable>
                                <Option v-for="(leg, i) in leagues" :key="i" :value="leg.id">{{ leg.league }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <FormItem label="Team Name" prop="team">
                            <Input v-model="team.team" type="text" placeholder="PSG"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateTeamForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addTeam('validateTeamForm')" type="primary" :disabled="isSaving"
                    :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingTeamModal" title="Edit Team" width="30%">
            <template>
                <Form ref="validateEditTeamForm" :model="team" :rules="validateTeam">
                    <Row>
                        <Col span="24">
                        <FormItem label="League" prop="league">
                            <Select v-model="team.league" placeholder="Please Select League" filterable>
                                <Option v-for="(leg, i) in leagues" :key="i" :value="leg.id">{{ leg.league }}</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="24">
                        <FormItem label="Team Name" prop="title">
                            <Input v-model="team.team" type="text" placeholder="PSG"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </template>
            <div slot="footer">
                <Button @click="closeModal('validateEditTeamForm')" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editTeam('validateEditTeamForm')" type="primary" :disabled="isSaving"
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
            addingTeamModal: false,
            editingTeamModal: false,
            deleteTeamModal: false,
            viewTeamModal: false,
            isSaving: false,
            teams: [],
            leagues: [],
            textTeam: [],
            tableLoading: true,
            keyword: "",
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            teamName: "",
            teamId: "",
            team: { team: "", league: "" },

            validateTeam: {
                team: [
                    {
                        required: true,
                        message: "Team name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
            validateUpdateTeam: {
                team: [
                    {
                        required: true,
                        message: "Team name cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            columns: [
                { title: "ID", slot: "number", sortable: true },
                { title: "League Name", slot: "league", align: "center" },
                { title: "Team Name", slot: "name", align: "center" },
                { title: "Action", slot: "action", align: "center" },
            ],
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getTeams();
        await this.getLeagues();
    },

    computed: {},

    methods: {

        async getLeagues() {
            const res = await this.callApi("get", "/get_leagues");
            if (res.data.status === "success") {
                this.leagues = res.data.data;
                this.tableLoading = false;
            } else {
                this.leagues = [];
            }
        },
        async confirmDeleteTeam() {
            this.isSaving = true;
            var data = { id: this.teamId };
            const res = await this.callApi("post", "/delete_team", data);
            if (res.data.status_code === 200) {
                this.getTeams();
                this.deleteTeamModal = false;
                this.isSaving = false;
                this.teamId = "";
                return this.s("Team was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }

        },

        deleteTeam(id, team) {
            this.deleteTeamModal = true;
            this.teamName = team;
            this.teamId = id;
        },
        viewTeam(team, league) {
            this.viewTeamModal = true;
            this.teamName = team;
            this.team.league = league;
        },
        teamColor(index) {
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

        async getTeams() {
            const res = await this.callApi("get", "/get_teams");
            if (res.data.status === "success") {
                this.teams = res.data.data;
                this.tableLoading = false;
            } else {
                this.teams = [];
            }
        },

        addTeam(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_team", this.team);
                    if (res.data.status_code === 201) {
                        this.getTeams();
                        this.addingTeamModal = false;
                        this.isSaving = false;
                        this.team.team = "";
                        this.$refs[name].resetFields();
                        return this.s("New team was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
        editTeamModal(index, id, name, leagueId) {
            this.editingTeamModal = true;
            this.rowIndex = index;
            this.teamId = id;
            this.team.team = name;
            this.team.league = leagueId;
        },

        editTeam(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.teamId, ...this.team };
                    const res = await this.callApi("post", "/edit_team", updatedData);
                    if (res.data.status === "success") {
                        await this.getTeams();
                        this.editingTeamModal = false;
                        this.isEditing = false;
                        this.team.team = "";
                        this.$refs[name].resetFields();
                        return this.s("Team was updated successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        closeModal(name) {
            this.addingTeamModal = false;
            this.editingTeamModal = false;
            this.deleteTeamModal = false;
            this.viewTeamModal = false;
            this.team.team = '';
            this.team.league = '';
            this.$refs[name].resetFields();
        },
    },
};
</script>
