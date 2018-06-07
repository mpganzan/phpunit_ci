<template>
    <div class="comment-box">
        <div class="card">
            <div class="card-body">
                <span class="close" v-show="owner" @click="deleteComment">&times;</span>
                <div>
                    <strong>{{ comment.user.name }}: </strong>
                    <span v-show="!update">{{ comment.content }}</span>
                    <div class="form" v-show="update">
                        <form @submit.prevent="updateComment">
                            <div class="form-group">
                                <textarea class="form-control" :class="{ 'is-invalid': form.errors.has('content') }" v-model="form.content"></textarea>
                                <has-error :form="form" field="content"></has-error>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary" :disabled="form.busy">Submit</button>
                                <button type="button" class="btn btn-sm" @click="cancelUpdate" :disabled="form.busy">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-md-1">
                    <button class="btn btn-sm" v-show="!update && owner" @click="enableUpdate">Edit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import swal from 'sweetalert2'
import { Form } from 'vform'

export default {
    name: 'comment-box',

    props: {
        comment: {
            type: Object,
            required: true
        },
        authCheck: {
            type: Number,
            required: true
        }
    },

    data: () => ({
        update: false,
        copy: '',
        form: new Form({
            content: ''
        })
    }),

    computed: {
        owner() {
            return this.authCheck == this.comment.user_id
        }
    },

    methods: {
        async updateComment() {
            try {
                const { data } = await this.form.patch(route('articles.comments.update', this.comment.id))

                this.update = false
                this.comment.content = this.form.content
            } catch (error) {
                console.log(error)
                swal('Oops...', 'Something went wrong!', 'error')
            }
        },

        enableUpdate() {
            this.update = true
            this.$set(this, 'copy', this.comment.content)
            this.$set(this.form, 'content', this.comment.content)
        },

        cancelUpdate() {
            this.update = false
            this.comment.content = this.copy
        },

        deleteComment() {
            swal({
                title: 'Confirm',
                text: 'Are you sure you want to delete your comment?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        axios.delete(route('articles.comments.delete', this.comment.id))
                            .then(({ data }) => {
                                resolve()
                            })
                            .catch(({ response }) => {
                                swal.showValidationError('Something went wrong')
                            })
                    })
                }
            }).then((result) => {
                if (result.value) {
                    swal({
                        type: 'success',
                        title: 'Success!',
                        text: 'Comment successfully deleted.'
                    })

                    this.$emit('delete-comment')
                }
            })
        }
    }
}
</script>

<style scoped>
.comment-box {
    margin-bottom: 15px;
}
</style>
