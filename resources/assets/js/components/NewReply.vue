<template>
    <div>
        <div v-if="canReply">
            <div class="form-group">
                <textarea name="body" 
                    id="post-reply-body" 
                    class="form-control"
                    cols="2" 
                    rows="4"
                    placeholder="Say something..." 
                    v-model="body" 
                    required></textarea>
            </div> 
            <button type="submit"
                @click="postReply" 
                class="btn btn-primary"><i class="fas fa-comment "></i> Reply</button>
        </div>
        <div v-else>
            Please <a href="/login">sign in</a> to participate in the discussion.
        </div>
    </div>
</template>

<script>
export default {
    props: ['data', 'endpoint'],
    data() {
        return {
            body : ''
        }
    },
    computed: {
        canReply() {
            return window.App.signedIn;
        }
    },
    methods: {
        postReply() {
            axios.post(this.endpoint, {
                    body : this.body
                })
                .then(({data}) => {
                    this.body = '',
                    this.$emit('posted', data);
                    flash('Your reply Has been posted');
                });
                
        }
    }
}
</script>

