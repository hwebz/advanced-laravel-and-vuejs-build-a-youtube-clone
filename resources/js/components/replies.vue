<template>
    <div>
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

    export default {
        components: {
            Avatar
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
        watch: {
            comment(newVal) {
                this.replies = {
                    data: [],
                    next_page_url: `/comments/${newVal.id}/replies`
                }

                this.fetchReplies();
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
            },
            addReply(reply) {
                this.replies = {
                    ...this.replies,
                    data: [
                        reply,
                        ...this.replies.data
                    ]
                }
            }
        }
    }
</script>
