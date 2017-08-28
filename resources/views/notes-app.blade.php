<div id="notes-app">
    <div class="container">
        <div class="page-header">
            <h1>My Notes <small>Test task</small></h1>
        </div>

        <button v-if="! formMode" class="btn btn-success" @click="createNote"><span class="glyphicon glyphicon-plus"></span> Create a note</button>

        <div v-if="formMode" class="form-mode-area">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <note-form :errors="errors" @save="saveNote($event)" @cancel="cancel"></note-form>
                </div>
            </div>
        </div>

        <div class="list-mode-area" v-if="! formMode">
            <div class="note-searching">
                <div class="row">
                    <div class="col-lg-5 col-lg-offset-3">
                        <div class="input-group input-group-lg">
                            <input type="text" v-model.trim="search" class="form-control" placeholder="Search for note...">
                            <span class="input-group-btn"><button class="btn btn-default" type="button" @click="search = ''" :disabled="search.length === 0"><span class="glyphicon glyphicon-remove-circle"></span></button></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="notes-info">
                Total notes: <span v-text="paginator.total"></span>
            </div>

            <div class="row">
                <div v-for="(note, index) in paginator.data" :key="note.id" class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <note :note="note" @read="showNote(note)" @destroy="removeNote(index)"></note>
                </div>
            </div>

            <template v-if="paginator.total > 0 && paginator.total > paginator.per_page">
                <paginator
                        :page="paginator.current_page"
                        :pages-count="paginator.last_page"
                        @page-updated="setPage($event)"
                ></paginator>
            </template>
        </div>
    </div>
</div>