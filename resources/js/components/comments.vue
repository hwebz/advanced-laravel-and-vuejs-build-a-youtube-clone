<template>
    <div class="card mt-5 p-5">
        <div class="media" v-for="(comment, commentIndex) in comments.data" :key="commentIndex">
            <avatar :username="comment.user.name" :size="30" class="mr-3" />

            <div class="media-body">
                <h6 class="mt-0">
                    {{ comment.user.name }}
                </h6>
                <small>{{ comment.body }}</small>
                <div class="form-inline my-4 w-full">
                    <input type="text" class="form-control form-control-sm w-80" />
                    <button class="btn btn-sm btn-primary">
                        <small>Add comment</small>
                    </button>
                </div>

                <div class="media mt-3">
                    <a href="#" class="mr-3">

                    </a>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-success">
                Load More
            </button>
        </div>
    </div>
</template>

<script>
    import Avatar from 'vue-avatar';

    export default {
        components: {
            Avatar
        },
        props: {
            video: {
                type: Object,
                required: true,
                default: () => {}
            }
        },
        data() {
            return {
                comments: {
                    data: []
                }
            }
        },
        mounted() {
            this.fetchComments()
        },
        methods: {
            fetchComments() {
                axios.get(`/videos/${this.video.id}/comments`)
                    .then(({ data }) => {
                        this.comments = data;
                    })
            }
        }
    }
</script>
