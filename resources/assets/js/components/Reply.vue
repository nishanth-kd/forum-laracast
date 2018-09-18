<template>
        <div class="card card-default border-light" style="margin-bottom:10px">
            <div class="card-header border-light text-secondary d-flex justify-content-between" :id ="'reply-' + data.id">
                <div class="align-middle">
                    <a :href="'/profiles/' + data.owner.name" style="padding: 6px 0;" class="align-middle" v-text="data.owner.name"></a> said <a :href="'#reply-' + data.id" v-text="ago"></a>
                </div>
                <div>
                    <favorite v-if="canFavorite" :model="data"></favorite>
                    &nbsp;
                    <div v-if="canUpdate" class="text-muted d-inline" data-toggle="tooltip" data-placement="top" title="Edit">
                        <a @click="editing = true" class="bg-light text-muted"><i class="fas fa-edit"></i></a>
                    </div>
                    &nbsp;
                    <div v-if="canUpdate" class="text-muted d-inline" data-toggle="tooltip" data-placement="top" title="Delete">
                        <i @click="destroy" class="bg-light text-muted fas fa-times"></i>
                    </div>
                </div>
            </div>
            <div class="card-body border-light text-secondary">
                <div v-if="editing">
                    <div class="form-group">
                        <textarea name="body" :id="'body-update-reply-' + data.id" cols="2" v-model="body" class="form-control"></textarea>
                    </div>
                    <button @click="update" class="btn btn-primary btn-sm">Update</button>
                    <button @click="editing = false" class="btn btn-light btn-sm text-danger">Cancel</button>
                </div>
                <div v-else v-text="body"></div>
            </div>
        </div>
</template>

<script>
    import moment from 'moment';
    export default {
        props:['data'],
        data() {
            return {
                editing: false,
                body: this.data.body
            }
        },
        computed: {
            canFavorite() {
                return window.App.signedIn;
            },
            canDelete() {
                return this.authorize(user => this.data.user_id == user.id);
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            },
            ago() {
                return moment(this.data.created_at + 'Z').fromNow();
            }
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body : this.body
                }); 
                this.editing = false;
                flash("Your reply has been updated.");
            },
            destroy() {
                axios.delete('/replies/' + this.data.id); 
                this.$emit('deleted', this.data.id);
                flash("Your reply has been deleted.");
            }
        }
    }
</script>