<div id="notes-app">
    <div class="container">
        <div class="page-header">
            <h1>My Notes <small>Test task</small></h1>
        </div>

        <button v-if="! formMode" class="btn btn-success" @click="createNote"><span class="glyphicon glyphicon-plus"></span> Create a note</button>

        <div v-if="formMode" class="form-mode-area">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <form>
                        <div class="form-group" :class="{'has-error': errors.hasOwnProperty('title')}">
                            <label for="input-title">Note title</label>
                            <input id="input-title" type="text" class="form-control" v-model.trim="formData.title">

                            <p class="help-block">
                                <template v-if="errors.hasOwnProperty('title')">
                                    <span v-for="errorMsg in errors.title" v-text="errorMsg"></span>
                                </template>

                                <span v-else>Use short and self-expressive title</span>
                            </p>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.hasOwnProperty('body')}">
                            <label for="input-body">Note body</label>
                            <textarea id="input-body" class="form-control" v-model.trim="formData.body" rows="10"></textarea>

                            <p class="help-block">
                                <template v-if="errors.hasOwnProperty('body')">
                                    <span v-for="errorMsg in errors.body" v-text="errorMsg"></span>
                                </template>

                                <span v-else>You can type whatever you want</span>
                            </p>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-default" @click.prevent="cancel">Cancel</button>
                            <button class="btn btn-success" @click.prevent="saveNote">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="list-mode-area" v-if="! formMode">
            <div class="note-searching">
                <div class="row">
                    <div class="col-lg-5 col-lg-offset-3">
                        <div class="input-group">
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
                <div v-for="(note, index) in paginator.data" class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="note panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title" v-text="note.title"></h3>
                        </div>

                        <div class="note-body panel-body" v-text="note.body"></div>

                        <div class="panel-footer">
                            <time class="text-muted" v-text="note.updated_at"></time>
                            <button class="btn btn-danger btn-xs pull-right" @click="removeNote(index)"><span class="glyphicon glyphicon-trash"></span></button>
                        </div>
                    </div>
                </div>
            </div>

            <nav v-if="paginator.total > 0 && paginator.total > paginator.per_page" aria-label="Page navigation">
                <ul class="pagination">
                    <li :class="{ disabled: paginator.prev_page_url === null}">
                        <a v-if="paginator.prev_page_url !== null" href="#" @click.prevent="prevPage" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>

                        <span v-else aria-hidden="true">&laquo;</span>
                    </li>

                    <li v-for="pageNum in paginator.last_page" :class="{ active: pageNum === paginator.current_page }"><a href="#" @click.prevent="setPage(pageNum)" v-text="pageNum"></a></li>

                    <li :class="{ disabled: paginator.next_page_url === null }">
                        <a v-if="paginator.next_page_url !== null" href="#" @click.prevent="nextPage" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>

                        <span v-else aria-hidden="true">&raquo;</span>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>