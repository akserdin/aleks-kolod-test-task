<template>
    <div class="note panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title" v-text="note.title"></h3>
        </div>

        <div class="note-body panel-body" @click="readMe">
            {{ note.body | cutText(180, '...') }}
        </div>

        <div class="panel-footer">
            <time class="text-muted">{{ note.created_at | dateFromNow }}</time>
            <button class="btn btn-danger btn-xs pull-right" @click="removeMe(note.id)"><span class="glyphicon glyphicon-trash"></span></button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            note: Object
        },

        data() {
            return {};
        },

        filters: {
            dateFromNow(value) {
                if (!value) return '';

                value = value.toString();

                return moment.utc(value).fromNow();
            },

            cutText(text, length = 180, addString = '...') {
                if (!text) return '';

                text = text.toString();

                return text.length < length ? text : text.slice(0, length) + addString;
            }
        },

        methods: {
            readMe() {
                this.$emit('read');
            },

            removeMe() {
                this.$emit('destroy');
            },
        }
    }
</script>
