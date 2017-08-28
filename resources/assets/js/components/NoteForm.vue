<template>
    <form class="form-horizontal">
        <div class="form-group" :class="{'has-error': errors.hasOwnProperty('title')}">
            <label for="input-title" class="col-sm-3 control-label">Note title</label>
            <div class="col-sm-9">
                <input id="input-title" type="text" class="form-control input-lg" v-model.trim="title">

                <p class="help-block">
                    <template v-if="errors.hasOwnProperty('title')">
                        <span v-for="errorMsg in errors.title" v-text="errorMsg"></span>
                    </template>

                    <span v-else>Use short and self-expressive title</span>
                </p>
            </div>
        </div>

        <div class="form-group" :class="{'has-error': errors.hasOwnProperty('body')}">
            <label for="input-body" class="col-sm-3 control-label">Note body</label>

            <div class="col-sm-9">
                <textarea id="input-body" class="form-control input-lg" v-model.trim="body" rows="8"></textarea>

                <p class="help-block">
                    <template v-if="errors.hasOwnProperty('body')">
                        <span v-for="errorMsg in errors.body" v-text="errorMsg"></span>
                    </template>

                    <span v-else>You can type whatever you want</span>
                </p>
            </div>
        </div>

        <button class="btn btn-success btn-sm pull-right" @click.prevent="save">Save</button>
        <button class="btn btn-default btn-sm pull-right" @click.prevent="$emit('cancel')">Cancel</button>
    </form>
</template>

<script>
    export default {
        props: ['errors'],

        data() {
            return {
                title: '',
                body: ''
            };
        },

        methods: {
            save() {
                let vm = this;

                this.$emit('save', {
                    title: vm.title,
                    body: vm.body
                });
            }
        }
    }
</script>