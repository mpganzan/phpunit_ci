<template>
    <div class="card">
        <div class="card-header">Post A Comment</div>
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="form-group">
                    <textarea
                        v-model="form.content"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('content') }"
                        placeholder="Write a comment here..."
                    ></textarea>
                    <has-error :form="form" field="content"></has-error>
                </div>
                <div class="form-group">
                    <button :disabled="form.busy" type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Form } from 'vform'
import swal from 'sweetalert2'

export default {
    name: 'comment-composer',

    props: {
        articleId: {
            type: Number,
            required: true
        }
    },

    data: () => ({
        form: new Form({
            content: ''
        })
    }),

    methods: {
        async submit() {
            try {
                const { data } = await this.form.post(route('articles.comments.store', this.articleId))

                this.form.content = ''
                this.$emit('add-comment', data.comment)
            } catch (error) {
                console.log(error)
                swal('Oops...', 'Something went wrong!', 'error')
            }
        }
    }
}
</script>

