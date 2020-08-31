<template>
    <div class="card mt-5 p-5">
        <div class="form-inline my-4 w-full">
            <input type="text" class="form-control form-control-sm w-80" />
            <button class="btn btn-sm btn-primary">
                <small>Add comment</small>
            </button>
        </div>

        <div class="media my-3" v-for="(comment, commentIndex) in comments.data" :key="commentIndex">
            <avatar :username="comment.user.name" :size="30" class="mr-3" />

            <div class="media-body">
                <h6 class="mt-0">
                    {{ comment.user.name }}
                </h6>
                <small>{{ comment.body }}</small>

                <votes
                    :default_votes="comment.votes"
                    :entity_id="comment.id"
                    :owner_id="comment.user.id"
                />
                <replies :comment="comment" />
            </div>
        </div>

        <div class="text-center">
            <button v-if="comments.next_page_url" @click="fetchComments" class="btn btn-success">
                Load More
            </button>
            <span v-else>No more comments to show</span>
        </div>
    </div>
</template>

<script>
    import Avatar from 'vue-avatar';
    import Replies from './replies.vue';
    import Votes from './votes.vue';

    export default {
        components: {
            Avatar,
            Replies,
            Votes
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
                const url = this.comments.next_page_url ? this.comments.next_page_url : `/videos/${this.video.id}/comments`;
                axios.get(url)
                    .then(({ data }) => {
                        this.comments = {
                            ...data,
                            data: [
                                ...this.comments.data,
                                ...data.data
                            ]
                        }


                    });
            }
        }
    }
</script>
