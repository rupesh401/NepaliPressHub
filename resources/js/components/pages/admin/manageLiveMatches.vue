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
                                    <Button @click="addingMatchModal = true" type="primary" ghost>
                                        <Icon type="md-add" />
                                        Add Match
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
                                        <li class="active">Matches</li>
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
                                            <Select v-model="teamFilter" placeholder="Filter by Team Name" filterable>
                                                <Option value="">All Teams</Option>
                                                <Option v-for="(team, i) in teams" :key="i" :value="team.team">{{ team.team
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
                                                    <th width="5%">ID</th>
                                                    <th width="20%">Home Team</th>
                                                    <th width="20%">Away Team</th>
                                                    <th width="10%">Time</th>
                                                    <th width="10%">Date</th>
                                                    <th width="10%">Status</th>
                                                    <th width="10%">Result</th>
                                                    <th width="15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(match, i) in newDatas" :key="i">
                                                    <td>{{ ++i }}</td>
                                                    <td>{{ match.home.team }}</td>
                                                    <td>{{ match.away.team }}</td>
                                                    <td>{{ match.result.time }}</td>
                                                    <td>{{ match.result.date }}</td>
                                                    <td>{{ match.result.status }}</td>
                                                    <td>{{ match.result.home_score }} - {{ match.result.away_score }} </td>
                                                    <td>
                                                        <Button
                                                            @click="viewMatch(match.home.team, match.away.team, match.result.date,
                                                                match.result.time, match.result.status, match.result.home_score, match.result.away_score, match.result.home_scorer, match.result.away_scorer,
                                                                match.result.possesion_home, match.result.possesion_away, match.result.corner_home, match.result.corner_away, match.result.shorts_home, match.result.shorts_away,
                                                                match.result.passes_home, match.result.passes_away, match.result.shorts_off_home, match.result.shorts_off_away)"
                                                            size="small">
                                                            <Icon type="ios-eye-outline" color="blue" size="20" />
                                                        </Button>
                                                        <Button
                                                            @click="editMatchModal(match.id, match.result.id, match.team_home_id,
                                                                match.team_away_id, match.result.date, match.result.time,
                                                                match.result.status, match.result.home_score, match.result.away_score, match.result.home_scorer, match.result.away_scorer,
                                                                match.result.possesion_home, match.result.possesion_away, match.result.corner_home, match.result.corner_away, match.result.shorts_home, match.result.shorts_away,
                                                                match.result.passes_home, match.result.passes_away,
                                                                match.result.shorts_off_home, match.result.shorts_off_away)"
                                                            size="small">
                                                            <Icon type="ios-create-outline" color="green" size="20" />
                                                        </Button>
                                                        <Button v-if="$store.state.userInfos.level == 1"
                                                            @click="deleteMatch(match.id, match.home.team, match.away.team)"
                                                            size="small">
                                                            <Icon type="ios-trash-outline" color="red" size="20" />
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

        <Modal v-model="deleteMatchModal" title="View Match" width="30%" class="text-center">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p><strong>Are you sure you want to delete this <i>{{ match.home_team }} vs {{ match.away_team }}</i>
                        match?</strong></p>
                <p>This action cannot be undone. Once deleted, the match will be permanently removed.</p>
            </div>
            <div slot="footer">
                <Button @click="confirmDeleteMatch()" type="error">
                    <Icon type="ios-trash" size="18" />
                    Delete
                </Button>
                <Button @click="closeModal()" type="warning">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
            </div>
        </Modal>
        <Modal v-model="viewMatchModal" title="View Match" width="50%" class="text-center">
            <template>
                <p>Match Between: <Tag :color="matchColor(1)" type="border">{{ match.home_team }}</Tag> Vs
                    <Tag :color="matchColor(1)" type="border">{{ match.home_team }}</Tag>
                </p>
                <p>Results: <Tag :color="matchColor(1)" type="border">{{ match.home_score }}</Tag> - <Tag
                        :color="matchColor(1)" type="border">{{ match.away_score }}</Tag>
                </p>
                <p>Scorer: <Tag :color="matchColor(1)" type="border">{{ (match.home_scorer) }}</Tag> ---
                    <Tag :color="matchColor(1)" type="border">{{ (match.away_scorer) }}</Tag>
                </p>
                <p>Date: <Tag :color="matchColor(1)" type="border">{{ match.date }}</Tag>
                </p>
                <p>Time: <Tag :color="matchColor(1)" type="border">{{ match.time }}</Tag>
                </p>
                <p>Status: <Tag :color="matchColor(1)" type="border">{{ match.status }}</Tag>
                </p>
            </template>
            <div slot="footer">
                <Button @click="closeModal()" type="success">
                    <Icon type="ios-done-all" size="18" />
                    Ok
                </Button>
            </div>
        </Modal>

        <Modal v-model="addingMatchModal" title="Add Match" width="60%">
            <template>
                <Form ref="validateMatchForm" :model="match" :rules="validateMatch">
                    <Row>
                        <Col span="9">
                        <FormItem label="Home Team" prop="home_team">
                            <Select v-model="match.home_team" placeholder="Please Select home team" filterable>
                                <Option v-for="(team, i) in homeTeamOptions" :key="i" :value="team.id">{{ team.team }}
                                </Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="2">
                        <FormItem label="Score" prop="home_score">
                            <Input v-model="match.home_score"></Input>
                        </FormItem>
                        </Col>

                        <Col span="9" offset="2">
                        <FormItem label="Away Team" prop="away_team">
                            <Select v-model="match.away_team" placeholder="Please Select away team" filterable>
                                <Option v-for="(team, i) in awayTeamOptions" :key="i" :value="team.id">{{ team.team }}
                                </Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="2">
                        <FormItem label="Score" prop="away_score">
                            <Input v-model="match.away_score"></Input>
                        </FormItem>
                        </Col>
                        <Col span="8">
                        <FormItem label="Match Date" prop="date">
                            <DatePicker v-model="match.date" type="date" :options="options1" placeholder="Select Match date"
                                style="width: 100%;" />
                        </FormItem>
                        </Col>
                        <Col span="7" offset="1">
                        <FormItem label="Match Time" prop="time">
                            <TimePicker v-model="match.time" format="HH:mm" placeholder="Select match time"
                                style="width: 100%;" />
                        </FormItem>
                        </Col>
                        <Col span="7" offset="1">
                        <FormItem label="Status" prop="status">
                            <Select v-model="match.status" filterable placeholder="Please select match status">
                                <Option value="Not Started">Not Started</Option>
                                <Option value="Started">Started</Option>
                                <Option value="1st Half">1st Half</Option>
                                <Option value="Halftime">Halftime</Option>
                                <Option value="2nd Half">2nd Half</Option>
                                <Option value="Extra Time">Extra Time</Option>
                                <Option value="Penalties">Penalties</Option>
                                <Option value="Finished">Finished</Option>
                                <Option value="Postponed">Postponed</Option>
                                <Option value="Cancelled">Cancelled</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="11">
                        <FormItem label="Home Scorer" prop="home_scorer">
                            <Input v-model="match.home_scorer"></Input>
                        </FormItem>
                        </Col>
                        <Col span="11" offset="2">
                        <FormItem label="Away Scorer" prop="away_scorer">
                            <Input v-model="match.away_scorer"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
                <template v-if="match.status === 'Finished' || match.status === 'Halftime'">
                    <Form label-position="left" :label-width="70">
                        <Row>
                            <p style="color: red;">Home Team Statistics</p>
                            <Col span="5">
                            <FormItem label="Possession ">
                                <InputNumber :max="100" :min="0" v-model="match.possesion_home" />
                            </FormItem>
                            </Col>
                            <Col span="4">
                            <FormItem label="Corners ">
                                <InputNumber v-model="match.corner_home" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Shorts on">
                                <InputNumber v-model="match.shorts_home" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Shorts off ">
                                <InputNumber v-model="match.shorts_off_home" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Passes ">
                                <InputNumber v-model="match.passes_home" />
                            </FormItem>
                            </Col>


                            <p style="color: red;">Away Team Statistics</p>
                            <Col span="5">
                            <FormItem label="Possession ">
                                <InputNumber :max="100" :min="0" v-model="match.possesion_away" />
                            </FormItem>
                            </Col>
                            <Col span="4">
                            <FormItem label="Corners ">
                                <InputNumber v-model="match.corner_away" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Shorts on">
                                <InputNumber v-model="match.shorts_away" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Shorts off ">
                                <InputNumber v-model="match.shorts_off_away" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Passes ">
                                <InputNumber v-model="match.passes_away" />
                            </FormItem>
                            </Col>
                        </Row>
                    </Form>
                </template>
            </template>
            <div slot="footer">
                <Button @click="closeModal()" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="addMatch('validateMatchForm')" type="primary" :disabled="isSaving" :loading="isSaving">
                    <Icon type="md-document" size="18" />
                    {{ isSaving ? "Saving..." : "Save" }}
                </Button>
            </div>
        </Modal>

        <Modal v-model="editingMatchModal" title="Edit Match" width="60%">
            <template>
                <Form ref="validateEditMatchForm" :model="match" :rules="validateMatch">
                    <Row>
                        <Col span="9">
                        <FormItem label="Home Team" prop="home_team">
                            <Select v-model="match.home_team" placeholder="Please Select home team" filterable>
                                <Option v-for="(team, i) in homeTeamOptions" :key="i" :value="team.id">{{ team.team }}
                                </Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="2">
                        <FormItem label="Score" prop="home_score">
                            <Input v-model="match.home_score"></Input>
                        </FormItem>
                        </Col>

                        <Col span="9" offset="2">
                        <FormItem label="Away Team" prop="away_team">
                            <Select v-model="match.away_team" placeholder="Please Select away team" filterable>
                                <Option v-for="(team, i) in awayTeamOptions" :key="i" :value="team.id">{{ team.team }}
                                </Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="2">
                        <FormItem label="Score" prop="away_score">
                            <Input v-model="match.away_score"></Input>
                        </FormItem>
                        </Col>
                        <Col span="8">
                        <FormItem label="Match Date" prop="date">
                            <DatePicker v-model="match.date" type="date" :options="options1" placeholder="Select Match date"
                                style="width: 100%;" />
                        </FormItem>
                        </Col>
                        <Col span="7" offset="1">
                        <FormItem label="Match Time" prop="time">
                            <TimePicker v-model="match.time" format="HH:mm" placeholder="Select match time"
                                style="width: 100%;" />
                        </FormItem>
                        </Col>
                        <Col span="7" offset="1">
                        <FormItem label="Status" prop="status">
                            <Select v-model="match.status" filterable placeholder="Please select match status">
                                <Option value="Not Started">Not Started</Option>
                                <Option value="Started">Started</Option>
                                <Option value="1st Half">1st Half</Option>
                                <Option value="Halftime">Halftime</Option>
                                <Option value="2nd Half">2nd Half</Option>
                                <Option value="Extra Time">Extra Time</Option>
                                <Option value="Penalties">Penalties</Option>
                                <Option value="Finished">Finished</Option>
                                <Option value="Postponed">Postponed</Option>
                                <Option value="Cancelled">Cancelled</Option>
                            </Select>
                        </FormItem>
                        </Col>
                        <Col span="11">
                        <FormItem label="Home Scorer" prop="home_scorer">
                            <Input v-model="match.home_scorer"></Input>
                        </FormItem>
                        </Col>
                        <Col span="11" offset="2">
                        <FormItem label="Away Scorer" prop="away_scorer">
                            <Input v-model="match.away_scorer"></Input>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
                <template v-if="match.status === 'Finished' || match.status === 'Halftime'">
                    <Form label-position="left" :label-width="70">
                        <Row>
                            <p style="color: red;">Home Team Statistics</p>
                            <Col span="5">
                            <FormItem label="Possession ">
                                <InputNumber :max="100" :min="0" v-model="match.possesion_home" />
                            </FormItem>
                            </Col>
                            <Col span="4">
                            <FormItem label="Corners ">
                                <InputNumber v-model="match.corner_home" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Shorts on">
                                <InputNumber v-model="match.shorts_home" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Shorts off ">
                                <InputNumber v-model="match.shorts_off_home" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Passes ">
                                <InputNumber v-model="match.passes_home" />
                            </FormItem>
                            </Col>


                            <p style="color: red;">Away Team Statistics</p>
                            <Col span="5">
                            <FormItem label="Possession ">
                                <InputNumber :max="100" :min="0" v-model="match.possesion_away" />
                            </FormItem>
                            </Col>
                            <Col span="4">
                            <FormItem label="Corners ">
                                <InputNumber v-model="match.corner_away" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Shorts on">
                                <InputNumber v-model="match.shorts_away" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Shorts off ">
                                <InputNumber v-model="match.shorts_off_away" />
                            </FormItem>
                            </Col>
                            <Col span="5">
                            <FormItem label="Passes ">
                                <InputNumber v-model="match.passes_away" />
                            </FormItem>
                            </Col>
                        </Row>
                    </Form>
                </template>
            </template>
            <div slot="footer">
                <Button @click="closeModal()" type="error">
                    <Icon type="md-close-circle" size="18" />
                    Cancel
                </Button>
                <Button @click="editMatch('validateEditMatchForm')" type="primary" :disabled="isSaving" :loading="isSaving">
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
            addingMatchModal: false,
            editingMatchModal: false,
            deleteMatchModal: false,
            viewMatchModal: false,
            isSaving: false,
            matches: [],
            teams: [],
            homeScores: [],
            awayScores: [],
            textMatch: [],
            homeTeamOptions: [],
            awayTeamOptions: [],

            filteredMatches: [],
            teamFilter: "",
            awayLeague: "",

            tableLoading: true,
            keyword: "",
            isEditing: false,
            rowIndex: "",
            status: "",
            token: "",
            matchName: "",
            matchId: "",
            resultId: "",
            match: {
                home_team: "", home_score: 0, away_score: 0,
                away_team: "", date: "", minutes: 1,
                time: "", status: "", home_scorer: "", away_scorer: "",
                possesion_home: 0, possesion_away: 0,
                corner_home: 0, corner_away: 0,
                shorts_home: 0, shorts_away: 0,
                shorts_off_home: 0, shorts_off_away: 0,
                passes_home: 0, passes_away: 0
            },

            validateMatch: {
                match: [
                    {
                        required: true,
                        message: "Match team cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },
            validateUpdateMatch: {
                match: [
                    {
                        required: true,
                        message: "Match team cannot be empty.",
                        trigger: "blur",
                    },
                ],
            },

            columns: [
                { title: "ID", slot: "number", sortable: true },
                { title: "League Name", slot: "league", align: "center" },
                { title: "Match Name", slot: "name", align: "center" },
                { title: "Action", slot: "action", align: "center" },
            ],
            options1: {
                shortcuts: [
                    {
                        text: 'Today',
                        value() {
                            return new Date();
                        },
                    },
                    {
                        text: 'Tomorrow',
                        value() {
                            const date = new Date();
                            date.setDate(date.getDate() + 1);
                            return date;
                        },
                    },
                    {
                        text: 'Next Week',
                        value() {
                            const date = new Date();
                            date.setDate(date.getDate() + 7);
                            return date;
                        },
                    }
                ]

            }
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        await this.getMatches();
        await this.getTeams();
        this.homeTeamOptions = this.teams;
        this.updateAwayTeamOptions();
    },

    computed: {
        // Apply filters to the Ads
        newDatas() {
            let filteredMatches = this.matches;

            // Apply Team filter
            if (this.teamFilter) {
                filteredMatches = filteredMatches.filter(match => {
                    return (
                        match.home.team.toLowerCase().includes(this.teamFilter.toLowerCase()) ||
                        match.away.team.toLowerCase().includes(this.teamFilter.toLowerCase())
                    );
                });
            }

            return filteredMatches;
        }
    },
    watch: {
        'match.home_team': 'updateAwayTeamOptions',
        'match.possesion_home': function (newValue) {
            if (newValue) {
                this.match.possesion_away = 100 - newValue;
            }
        }
    },

    methods: {
        findLeague() {
            alert('changed')
        },

        formatScorer(scores) {
            if (scores) {
                return scores.replace(/,\s*/g, '<br>');
            } else {
                return scores;
            }

        },
        updateAwayTeamOptions() {
            // console.log(this.teams[0].league[0].league)
            this.awayTeamOptions = this.teams.filter(team => team.id != this.match.home_team && team.league[0].league == this.awayLeague);
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

        async confirmDeleteMatch() {
            this.isSaving = true;
            var data = { id: this.matchId };
            const res = await this.callApi("post", "/delete_match", data);
            if (res.data.status_code === 200) {
                this.getMatches();
                this.deleteMatchModal = false;
                this.isSaving = false;
                this.matchId = "";
                return this.s("Match was deleted successfully");
            } else {
                this.isSaving = false;
                return this.swr();
            }
        },

        deleteMatch(id, home_team, away_team) {
            this.deleteMatchModal = true;
            this.match.home_team = home_team;
            this.match.away_team = away_team;
            this.matchId = id;
        },

        viewMatch(home, away, date, time, status, home_score, away_score, home_scorer, away_scorer,
            possesion_home, possesion_away, corner_home, corner_away, shorts_home, shorts_away, passes_home, passes_away,
            shorts_off_home, shorts_off_away) {
            this.viewMatchModal = true;
            this.match.home_team = home;
            this.match.away_team = away;
            this.match.date = date;
            this.match.time = time;
            this.match.status = status;
            this.match.home_score = home_score;
            this.match.away_score = away_score;
            this.match.home_scorer = home_scorer;
            this.match.away_scorer = away_scorer;

            this.match.possesion_home = possesion_home;
            this.match.possesion_away = possesion_away;
            this.match.corner_home = corner_home;
            this.match.corner_away = corner_away;
            this.match.shorts_home = shorts_home;
            this.match.shorts_away = shorts_away;
            this.match.passes_home = passes_home;
            this.match.passes_away = passes_away;
            this.match.shorts_off_home = shorts_off_home;
            this.match.shorts_off_away = shorts_off_away;
        },
        matchColor(index) {
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

        async getMatches() {
            const res = await this.callApi("get", "/get_matches");
            if (res.data.status === "success") {
                this.matches = res.data.data;
                this.tableLoading = false;
            } else {
                this.matches = [];
            }
        },

        addMatch(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isSaving = true;
                    const res = await this.callApi("post", "/add_new_match", this.match);
                    if (res.data.status_code === 201) {
                        this.getMatches();
                        this.addingMatchModal = false;
                        this.isSaving = false;
                        this.match.match = "";
                        this.resetFields();
                        return this.s("New match was added successfully");
                    } else {
                        this.isSaving = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },
        editMatchModal(id, resultId, team_home_id, team_away_id, date, time, status, home_score, away_score, home_scorer, away_scorer,
            possesion_home, possesion_away, corner_home, corner_away, shorts_home, shorts_away, passes_home, passes_away,
            shorts_off_home, shorts_off_away) {
            this.editingMatchModal = true;
            this.matchId = id;
            this.resultId = resultId;
            this.match.home_team = team_home_id;
            this.match.away_team = team_away_id;
            this.match.date = date;
            this.match.time = time;
            this.match.status = status;
            this.match.home_score = home_score;
            this.match.away_score = away_score;
            this.match.home_scorer = home_scorer;
            this.match.away_scorer = away_scorer;

            this.match.possesion_home = possesion_home;
            this.match.possesion_away = possesion_away;
            this.match.corner_home = corner_home;
            this.match.corner_away = corner_away;
            this.match.shorts_home = shorts_home;
            this.match.shorts_away = shorts_away;
            this.match.passes_home = passes_home;
            this.match.passes_away = passes_away;
            this.match.shorts_off_home = shorts_off_home;
            this.match.shorts_off_away = shorts_off_away;
        },

        editMatch(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isEditing = true;
                    const updatedData = { id: this.matchId, resultId: this.resultId, ...this.match };
                    const res = await this.callApi("post", "/edit_match", updatedData);
                    if (res.data.status === "success") {
                        await this.getMatches();
                        this.editingMatchModal = false;
                        this.isEditing = false;
                        this.resetFields();
                        return this.s("Match was updated successfully");
                    } else {
                        this.isEditing = false;
                        return this.swr();
                    }
                } else {
                }
            });
        },

        closeModal() {
            this.addingMatchModal = false;
            this.editingMatchModal = false;
            this.deleteMatchModal = false;
            this.viewMatchModal = false;
            this.resetFields();
        },
        resetFields() {
            this.match.home_team = '';
            this.match.away_team = '';
            this.match.date = '';
            this.match.time = '';
            this.match.status = '';
            this.match.home_score = 0;
            this.match.away_score = 0;
            this.match.home_scorer = '';
            this.match.away_scorer = '';
            this.match.possesion_home = 0;
            this.match.possesion_away = 0;
            this.match.corner_home = 0;
            this.match.corner_away = 0;
            this.match.shorts_home = 0;
            this.match.shorts_away = 0;
            this.match.passes_home = 0;
            this.match.passes_away = 0;
            this.match.shorts_off_home = 0;
            this.match.shorts_off_away = 0;
        }
    },


};
</script>
