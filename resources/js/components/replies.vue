<template>
    <div>
        <div class="form-inline my-4 w-full">
            <input type="text" class="form-control form-control-sm w-80" />
            <button class="btn btn-sm btn-primary">
                <small>Add comment</small>
            </button>
        </div>
        <div class="media my-3" v-for="(reply, replyIndex) in replies.data" :key="replyIndex">
            <avatar :username="reply.user.name" :size="30" class="mr-3" />

            <div class="media-body">
                <h6 class="mt-0">
                    {{ reply.user.name }}
                </h6>
                <small>{{ reply.body }}</small>

                <votes
                    :default_votes="reply.votes"
                    :entity_id="reply.id"
                    :owner_id="reply.user.id"
                />
            </div>
        </div>

        <div v-if="replies.next_page_url && comment.repliesCount > 0" class="text-center">
            <button @click="fetchReplies" class="btn btn-info btn-xs">Load replies</button>
        </div>
    </div>
</template>

<script>
    import Avatar from 'vue-avatar';
    import Votes from './votes.vue';

    export default {
        components: {
            Avatar,
            Votes
        },
        props: {
            comment: {
                type: Object,
                required: true,
                default: () => {}
            }
        },
        data() {
            return {
                replies: {
                    data: [],
                    next_page_url: `/comments/${this.comment.id}/replies`
                }
            }
        },
        methods: {
            fetchReplies() {
                axios.get(this.replies.next_page_url)
                    .then(({ data }) => {
                        this.replies = {
                            ...data,
                            data: [
                                ...this.replies.data,
                                ...data.data
                            ]
                        }


                    })
            }
        }
    }
</script>
