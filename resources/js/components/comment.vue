<template>
    <div v-if="comment" class="media my-3">
        <avatar :username="comment.user.name" :size="30" class="mr-3" />

        <div class="media-body">
            <h6 class="mt-0">
                {{ comment.user.name }}
            </h6>
            <small>{{ comment.body }}</small>

            <div class="d-flex">
                <votes
                    :default_votes="comment.votes"
                    :entity_id="comment.id"
                    :owner_id="comment.user.id"
                />
                <button @click="addingReply = !addingReply" class="btn btn-sm ml-2" :class="{'btn-default' : !addingReply, 'btn-danger': addingReply}">{{ addingReply ? 'Cancel' : 'Add Reply' }}</button>
            </div>

            <div v-if="addingReply" class="form-inline my-4 w-full">
                <input v-model="body" type="text" class="form-control form-control-sm w-80" />
                <button @click="addReply" class="btn btn-sm btn-primary">
                    <small>Add Reply</small>
                </button>
            </div>

            <replies ref="replies" :comment="comment" />
        </div>
    </div>
</template>

<script>
    import Avatar from 'vue-avatar';
    import Replies from './replies.vue';

    export default {
        components: {
            Avatar,
            Replies
        },
        props: {
            comment: {
                required: true,
                default: () => {}
            },
            video: {
                required: true,
                default: () => {}
            }
        },
        data() {
            return {
                body: '',
                addingReply: false
            }
        },
        methods: {
            addReply() {
                if (!this.body) return;

                axios.post(`/comments/${this.video.id}`, {
                    comment_id: this.comment.id,
                    body: this.body
                }).then(({ data }) => {
                    this.body = '';
                    this.addingReply = false;
                    this.$refs.replies.addReply(data);
                })
            }
        }
    }
</script>
