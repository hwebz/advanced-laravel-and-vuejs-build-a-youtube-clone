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
                <input type="text" class="form-control form-control-sm w-80" />
                <button class="btn btn-sm btn-primary">
                    <small>Add comment</small>
                </button>
            </div>

            <replies :comment="comment" />
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
                default: () => ({})
            }
        },
        data() {
            return {
                addingReply: false
            }
        }
    }
</script>
