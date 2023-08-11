<template>
    <div>
        <Leftbar />

        <Navbar />
        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 p-r-0 title-margin-right">
                            <div class="page-header">
                                <div class="page-title">
                                    <h1>Dashboard</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-l-0 title-margin-left">
                            <div class="page-header">
                                <div class="page-title">
                                    <ol class="breadcrumb text-right">
                                        <li><a href="#">Dashboard</a></li>
                                        <li class="active">Home</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="main-content">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="media">
                                        <div class="media-left meida media-middle">
                                            <span><i
                                                    class="ti-write f-s-22 color-primary border-primary round-widget"></i></span>
                                        </div>
                                        <div class="media-body media-text-right">
                                            <h4>{{ totalPost }}</h4>
                                            <h6>Total Posts</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="media">
                                        <div class="media-left meida media-middle">
                                            <span><i
                                                    class="ti-comment-alt f-s-22 color-warning border-warning round-widget"></i></span>
                                        </div>
                                        <div class="media-body media-text-right">
                                            <h4>{{ totalComments }}</h4>
                                            <h6>Total Comments</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="media">
                                        <div class="media-left meida media-middle">
                                            <span><i
                                                    class="ti-control-play f-s-22 color-success border-success round-widget"></i></span>
                                        </div>
                                        <div class="media-body media-text-right">
                                            <h4>{{ totalVideos }}</h4>
                                            <h6>Videos</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="media">
                                        <div class="media-left meida media-middle">
                                            <span><i
                                                    class="ti-email f-s-22 border-danger color-danger round-widget"></i></span>
                                        </div>
                                        <div class="media-body media-text-right">
                                            <h4>0</h4>
                                            <h6>Emails</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4 class="m-b-30">Latest Posts </h4>
                                    </div>
                                    <div class="recent-comment">

                                        <div v-for="(post, i) in posts" :key="i" class="media">
                                            <div class="media-left">
                                                <a>
                                                    <img :src="`${url_api}uploads/posts/${post.image}`" class=""
                                                        alt="Post Image" style="height: 70px; width: 100px; border-radius: 0px;"/>
                                                    </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{ post.title }}</h4>
                                                <p>{{ truncatedText(post.content) }}</p>
                                                <div class="comment-action">
                                                    <div v-if="post.status === 'Published'" class="badge badge-success">{{ post.status }}</div>
                                                    <div v-else class="badge badge-alert">{{ post.status }} </div> &nbsp;
                                                </div>
                                                <p class="comment-date">{{ post.created_at | formatDate }}</p> 
                                               
                                                <p class="comment-date"> &nbsp; &nbsp;Author: {{ post.usr[0].full_name }}</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4 class="m-b-30">Latest Comments </h4>
                                    </div>
                                    <div class="recent-comment">
                                        <div v-for="(comment, i) in comments" :key="i" class="media">
                                            <div class="media-left">
                                                <a>
                                                    <img class="media-object"
                                                        :src="`${public_asset}/profile.png`"
                                                        alt="Commenter Image" style="width: 50px;"></a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{ comment.name }}</h4>
                                                <p>{{ comment.comment }}</p>
                                                <div class="comment-action">
                                                    <div v-if="comment.status === 'Approved'" class="badge badge-success">Approved</div>
                                                    <div v-else class="badge badge-warning">Un Approved</div>
                                                </div>
                                                <p class="comment-date">&nbsp;{{ comment.created_at | formatDate }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4 class="mb-4">Login Logs</h4>
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive social_media_table">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="60%">Device and Browser</th>
                                                        <th width="10%">IP Adress</th>
                                                        <th width="20%">Login Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(log, i) in login_logs" :key="i">
                                                        <td>
                                                            <span class="text-muted">{{ log.user_agent }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="list-name">{{ log.ip_address }}</span>
                                                        </td>
                                                        <td>{{ log.login_time | formatDate }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Footer />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "../../inc/navbar";
import Leftbar from "../../inc/leftbar";
import Rightbar from "../../inc/rightbar";
import Footer from "../../inc/footer";
import moment from "moment";
export default {
    components: { Navbar, Leftbar, Rightbar, Footer },

    data() {
        return {
            login_logs: [],
            posts: [],
            videos: [],
            comments: [],
            totalPost: 0,
            totalVideos: 0,
            totalEmail: 0,
            totalComments: 0,
        };
    },
    async created() {
        await this.loginLogs();
        await this.getLatestPosts();
        await this.getLatestComments();
        await this.getLatestVideos();
        await this.getDataTotal();
    },
    methods: {
        truncatedText(content) {
            const contents = String(content);
            const regex = /<p[^>]*>([^<]+)<\/p>/i;
            const matches = contents.match(regex);
            let text = "";
            if (matches) {
                text = matches[1].replace(/<[^>]+>/g, "");
                text = text.split(" ").slice(0, 10).join(" ");
                if (text !== matches[1].replace(/<[^>]+>/g, "")) {
                    text += "...";
                }
            }
            return text;
        },
        async getDataTotal() {
            const res = await this.callApi("get", "/get_data_total");
            if (res.data.status === "success") {
                this.totalPost = res.data.totalPost;
                this.totalVideos = res.data.totalVideos;
                this.totalComments = res.data.totalComments;
            } else {
                this.totalPost = 0;
                this.totalVideos = 0;
                this.totalComments = 0;
            }
        },
        async getLatestComments() {
            const res = await this.callApi("get", "/get_latest_four_comments");
            if (res.data.status === "success") {
                this.comments = res.data.data;
            } else {
                this.comments = [];
            }
        },
        async getLatestVideos() {
            const res = await this.callApi("get", "/get_latest_four_videos");
            if (res.data.status === "success") {
                this.videos = res.data.data;
            } else {
                this.videos = [];
            }
        },
        async getLatestPosts() {
            const res = await this.callApi("get", "/get_latest_four_posts");
            if (res.data.status === "success") {
                this.posts = res.data.data;
            } else {
                this.posts = [];
            }
        },
        async loginLogs() {
            const res = await this.callApi("get", "login_logs");

            if (res.data.data) {
                this.login_logs = res.data.data;
            }
        },
    },
    filters: {
        formatDate(timestamp) {
            const date = moment(timestamp);
            const diffInMinutes = moment().diff(date, "minutes");

            if (diffInMinutes < 1440) {
                return date.fromNow();
            } else {
                return date.fromNow(true);
            }
        },
    },
};
</script>
