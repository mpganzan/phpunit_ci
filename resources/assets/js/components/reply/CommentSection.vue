<template>
    <div class="comments-section">
        <div class="comment-composer" v-if="authCheck != 0">
            <comment-composer :article-id="articleId" @add-comment="addComment"></comment-composer>
        </div>
        <div v-else>
            <h5><a :href="login">Login</a> to comment.</h5>
        </div>

        <div class="comments-box">
            <comment-box
                v-for="(comment, index) in comments.data"
                :key="index"
                :comment="comment"
                :auth-check="authCheck"
                @delete-comment="deleteComment(index)"
            ></comment-box>
        </div>

        <div class="pagination-container d-flex justify-content-center">
            <pagination :data="comments" @pagination-change-page="getComments"></pagination>
        </div>
    </div>
</template>

<script>
import CommentComposer from './CommentComposer'
import CommentBox from './CommentBox'

Vue.component('pagination', require("laravel-vue-pagination"))

export default {
    name: 'comment-section',

    props: {
        articleId: {
            type: Number,
            required: true
        },
        authCheck: {
            type: Number,
            required: true
        }
    },

    components: {
        CommentComposer,
        CommentBox
    },

    data: () => ({
        comments: {},
        page: 1
    }),

    computed: {
        login() {
            return route('login')
        }
    },

    methods: {
        async getComments(page = 1) {
            this.page = page;
            try {
                const { data } = await axios.get(
                    route('articles.comments', {
                        article: this.articleId,
                        page
                    })
                )

                this.$set(this, 'comments', data.comments)
            } catch (error) {
                console.log(error);
            }
        },

        addComment(comment) {
            this.getComments();
        },

        deleteComment(index) {
            if (this.comments.current_page == this.comments.last_page && this.comments.data.length == 1) {
                this.page = (this.page - 1) ? this.page - 1 : 1;
            }

            this.getComments(this.page);
        }
    },

    mounted() {
        this.getComments()
    }
}
</script>

<style scoped>
.comments-section {
    margin-top: 30px;
}
.comments-box {
    margin-top: 30px
}
</style>
