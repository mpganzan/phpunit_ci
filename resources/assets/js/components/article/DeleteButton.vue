<template>
    <button class="btn btn-danger" @click="deleteArticle"><i class="fa fa-trash"></i> Delete</button>
</template>

<script>
import swal from 'sweetalert2'

export default {
    name: 'delete-button',

    props: {
        articleId: {
            type: Number,
            required: true
        }
    },

    methods: {
        deleteArticle() {
            swal({
                title: 'Confirm',
                text: 'Are you sure you want to delete your article?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        axios.delete(route('articles.delete', this.articleId))
                            .then(({ data }) => {
                                resolve()
                            })
                            .catch(({ response }) => {
                                swal.showValidationError('Something went wrong!')
                            })
                    })
                }
            }).then((result) => {
                if (result.value) {
                    swal({
                        type: 'success',
                        title: 'Success!',
                        text: 'Article successfully deleted.'
                    }).then(() => {
                        window.location.replace(route('articles'))
                    })
                }
            })
        }
    }
}
</script>

