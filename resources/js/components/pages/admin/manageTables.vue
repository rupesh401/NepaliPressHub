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
                                        <li class="active">Leagues Table</li>
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
                                            <thead class="content-center" style="text-align: center;">
                                                <tr>
                                                    <th width="20%">ID</th>
                                                    <th width="50%">League</th>
                                                    <th width="20%">Action</th>
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

        <Modal v-model="viewLeagueModal" :title="`View Table - ${leagueName}`" width="70%" class="text-center">
            <template>
                <Table :loading="tableLoading" stripe border height="300" :columns="views" :data="sortedViewTeams">
                    <template slot-scope="{ row, index }" slot="index">
                        {{ ++index }}
                    </template>
                    <template slot-scope="{ row, index }" slot="p">
                        <p>{{ row.table[0].p }}</p>
                    </template>
                    <template slot-scope="{ row, index }" slot="w">
                        <p>{{ row.table[0].w }}</p>
                    </template>
                    <template slot-scope="{ row, index }" slot="d">
                        <p>{{ row.table[0].d }}</p>
                    </template>
                    <template slot-scope="{ row, index }" slot="l">
                        <p>{{ row.table[0].l }}</p>
                    </template>
                    <template slot-scope="{ row, index }" slot="pts">
                        <p>{{ row.table[0].pts }}</p>
                    </template>
                </Table>
            </template>
            <div slot="footer">
                <Button @click="closeModal()" type="success">
                    <Icon type="ios-done-all" size="18" />
                    Ok
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingTableModal" title="Edit Table" width="70%">
            <template>
                <Table :loading="tableLoading" stripe border height="300" :columns="columns" :data="teams">
                    <template slot-scope="{ row, index }" slot="index">
                        {{ ++index }}
                    </template>
                    <template slot-scope="{ row, index }" slot="p">
                        <Input v-model="row.table[0].p"></Input>
                    </template>
                    <template slot-scope="{ row, index }" slot="w">
                        <Input v-model="row.table[0].w"></Input>
                    </template>
                    <template slot-scope="{ row, index }" slot="d">
                        <Input v-model="row.table[0].d"></Input>
                    </template>
                    <template slot-scope="{ row, index }" slot="l">
                        <Input v-model="row.table[0].l"></Input>
                    </template>
                    <template slot-scope="{ row, index }" slot="pts">
                        <Input v-model="row.table[0].pts"></Input>
                    </template>
                    <template slot-scope="{ row, index }" slot="action">
                        <Button @click="updateTeamRow(row)" type="success" ghost size="small">
                            Update
                        </Button>

                    </template>
                </Table>
            </template>
            <div slot="footer">
                <Button @click="closeModal()" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
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
            editingTableModal: false,
            viewLeagueModal: false,
            isSaving: false,
            leagues: [],
            teams: [],
            viewTeams: [],
            teamUpdates: {},
            textLeague: [],
            tableLoading: true,
            keyword: "",
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            leagueName: "",
            leagueId: "",
            table: { p: "", w: "", d: "", l: "", pts: "", },
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
                { title: "No", slot: "index", align: "center", sortable: true, width: 80 },
                { title: "Team", key: "team", align: "center", sortable: true, width: 200 },
                { title: "P", slot: "p", align: "center", sortable: true },
                { title: "W", slot: "w", align: "center", sortable: true },
                { title: "D", slot: "d", align: "center", sortable: true },
                { title: "L", slot: "l", align: "center", sortable: true },
                { title: "PTS", slot: "pts", align: "center", sortable: true },
                { title: "Action", slot: "action", align: "center" }
            ],
            views: [
                { title: "No", slot: "index", align: "center", sortable: true, width: 80 },
                { title: "Team", key: "team", align: "center", sortable: true, width: 200 },
                { title: "P", slot: "p", align: "center", sortable: true },
                { title: "W", slot: "w", align: "center", sortable: true },
                { title: "D", slot: "d", align: "center", sortable: true },
                { title: "L", slot: "l", align: "center", sortable: true },
                { title: "PTS", slot: "pts", align: "center", sortable: true },
            ],
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getLeagues();
    },

    computed: {
        sortedViewTeams() {
            return this.viewTeams.slice().sort((a, b) => b.table[0].pts - a.table[0].pts);
        },
    },

    methods: {
        
        async updateTeamRow(row) {
            const updatedFields = row.table[0];
            if (Object.keys(updatedFields).length > 0) {
                const res = await this.callApi("post", "/update_table", updatedFields);
                if (res.data.status_code === 200) {
                    this.getLeagues();
                    this.isSaving = false;
                    this.leagueId = "";
                    return this.s("Table was updated successfully");
                } else {
                    this.isSaving = false;
                    return this.swr();
                }
            }
        },

        viewLeague(league) {
            this.viewTeams = this.teams
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
                this.teams = res.data.data[1].team;
                this.tableLoading = false;
            } else {
                this.leagues = [];
            }
        },

        editLeagueModal(index, id, name) {
            this.editingTableModal = true;
            this.rowIndex = index;
            this.leagueId = id;
            this.league.league = name;
        },

        closeModal() {
            this.editingTableModal = false;
            this.deleteLeagueModal = false;
            this.viewLeagueModal = false;
        },
    },
};
</script>
