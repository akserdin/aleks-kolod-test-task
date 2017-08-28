require('./bootstrap');

window.Vue = require('vue');
window.sweetAlert = require('sweetalert');
window.moment = require('moment');

const SWEETALERT_CONFIG = {
    title: 'Warning',
    text: 'This action cannot be undone. Are you sure?',
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#D9831F",
    confirmButtonText: "Delete",
    closeOnConfirm: true
};

Vue.component('note', require('./components/Note.vue'));
Vue.component('note-form', require('./components/NoteForm.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));

new Vue({
    el: '#notes-app',

    data: {
        paginator: {
            data: [],
            total: 0,
            current_page: 1,
            last_page: 1,
            from: 1,
            to: 1,
            next_page_url: null,
            prev_page_url: null
        },

        search: '',

        formMode: false,

        errors: {}
    },

    methods: {
        getNotes() {
            let vm = this;

            axios.get('/notes', {
                params: {
                    page: vm.paginator.current_page,
                    search: vm.search
                }
            })
                .then(vm.handleResponse)
                .catch(vm.handleError);
        },

        showNote(note) {
            sweetAlert({
                title: note.title,
                text: note.body,
                customClass: 'note-show',
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Close',
            });
        },

        reset() {
            let vm = this;

            vm.search = '';
            vm.paginator.data = [];
            vm.paginator.current_page = 1;
        },

        handleResponse(res) {
            let vm = this;

            vm.paginator = res.data;
        },

        handleError(err) {
            let vm = this;

            if (err.response && err.response.status === 422) {
                vm.errors = err.response.data;
            }
        },

        setPage(pageNum) {
            let vm = this;

            vm.paginator.current_page = pageNum;
            this.getNotes();
        },

        removeNote(index) {
            let vm = this;

            sweetAlert(SWEETALERT_CONFIG, function () {
                let id = vm.paginator.data[index].id;

                vm.reset();

                axios.delete('/note/' + id)
                    .then(vm.getNotes)
                    .catch(vm.handleError);
            });
        },

        createNote() {
            let vm = this;

            vm.errors = {};
            vm.formMode = true;
        },

        cancel() {
            let vm = this;

            vm.formMode = false;
            vm.errors = {};
            vm.search = '';
        },

        saveNote(note) {
            let vm = this;

            vm.errors = {};

            axios.post('/note', note)
                .then(function () {
                    vm.formMode = false;
                    vm.getNotes();
                })
                .catch(vm.handleError);
        },

        searchForNote: _.debounce(function () {
            let vm = this;

            vm.paginator.current_page = 1;
            vm.getNotes();
        }, 300)
    },

    watch: {
        search: function (updatedSearch) {
            let vm = this;

            if (updatedSearch.length === 0) {
                vm.reset();
                vm.getNotes();

                return;
            }

            if (updatedSearch.length > 2) {
                vm.searchForNote();
            }
        }
    },

    mounted() {
        this.getNotes();
    }
});
