<template>
    <!-- side right -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <ul class="nav nav-tabs nav-tabs-custom rightbar-nav-tab nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link py-3 active" data-toggle="tab" href="#chat-tab" role="tab">
                        <i class="mdi mdi-message-text font-size-22"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3" data-toggle="tab" href="#tasks-tab" role="tab">
                        <i class="mdi mdi-format-list-checkbox font-size-22"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3" data-toggle="tab" href="#settings-tab" role="tab">
                        <i class="mdi mdi-settings font-size-22"></i>
                    </a>
                </li>
            </ul>
            <div class="tab-content text-muted">
                <div class="tab-pane active" id="chat-tab" role="tabpanel">
                    <form class="search-bar py-4 px-3">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="mdi mdi-magnify"></span>
                        </div>
                    </form>
                    <div class="w-100 float-left p-2">
                        <button class="btn btn-primary waves-effect waves-light col-12 float-left" v-on:click="modalNoteAdd">Create note</button>
                    </div>
                    <div v-if="loading" class="bs-spinner text-center">
                        <div class="spinner-grow text-danger mr-2 mt-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-warning mr-2 mt-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-success mr-2 mt-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="w-100 float-left" v-for="data in PaginateNote.data" :key="data.id">
                        <a href="javascript: void(0);" class="text-reset notification-item pl-3 mb-2 d-block" v-on:click="modalNoteEdit(data.id)">
                            <div class="dropdown-divider" style="border-top-color: #bdbdbd;"></div>
                            <span class="mb-0">{{data.title}}</span>
                            <p class="text-truncate">{{data.note}}</p>
                        </a>
                    </div>
                    <pagination :data="PaginateNote" @pagination-change-page="appNote"></pagination>
                </div>
                <div class="tab-pane" id="tasks-tab" role="tabpanel">
                    <h6 class="p-3 mb-0 bg-light">Coming Soon...</h6>
                </div>
                <div class="tab-pane" id="settings-tab" role="tabpanel">
                    <h6 class="px-4 py-3 bg-light">General Settings</h6>
                    <div class="p-4">
                        <h6 class="mt-4">Auto Updates</h6>
                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="settings-check2" name="settings-check2" checked="">
                            <label class="custom-control-label font-weight-normal" for="settings-check2">Keep up to date</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal add note-->
        <div class="modal fade" id="addNote" tabindex="-1" role="dialog" aria-labelledby="modal-add-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-add-title">Add data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title_note_add">Title</label>
                            <input type="text" id="title_note_add" class="form-control" v-model="addNotes.title">
                        </div>
                        <div class="form-group">
                            <label for="note_note_add">Note</label>
                            <textarea type="text" id="note_note_add" class="form-control" v-model="addNotes.note"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="createNote">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal update note-->
        <div class="modal fade" id="editNote" tabindex="-1" role="dialog" aria-labelledby="modal-add-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-add-title">Edit data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title_note">Title</label>
                            <input type="text" id="title_note" class="form-control" v-model="editNotes.title">
                        </div>
                        <div class="form-group">
                            <label for="note_note">Note</label>
                            <textarea type="text" id="note_note" class="form-control" v-model="editNotes.note"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" v-on:click="deleteNote">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="createNote">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2';
export default{
    data() {
        return {
            PaginateNote : {},
            addNotes : {
                title : '',
                note : ''
            },
            editNotes : {
                id : '',
                title : '',
                note : ''
            },
            loading : false
        }
    },
    created() {
        this.appNote();
    },
    methods : {
        bugSweetAlert() {
            document.body.querySelector('button.swal2-confirm').addEventListener('click', function() {
                document.body.style.paddingRight = '0';
            });
        },
        async appNote(paginate = 1) {
            this.loading = true;
            await axios({
                url: '/api/note',
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                this.PaginateNote = result.data;
                this.loading = false;
            }).catch(error => {
                console.error(error.message);
            });
        },
        async createNote() {
            await axios({
                url: '/api/note',
                method: 'post',
                data : {
                    title : this.addNotes.title,
                    note : this.addNotes.note
                },
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#addNote').modal('hide');
                Swal.fire('Success!', result.data.message, 'success', 3000, false);
                this.appNote();
            }).catch(error => {
                $('#addNote').modal('hide');
                Swal.fire('Error!', error.message, 'error');
            });
        },
        modalNoteAdd() {
            $('#addNote').modal('show');
            document.body.classList.remove('right-bar-enabled');
        },
        async modalNoteEdit(id) {
            this.editNotes.id = id;
            await axios({
                url : '/api/note/' + id,
                method : 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                document.body.classList.remove('right-bar-enabled');
                $('#editNote').modal('show');
                result.data.forEach((val, key) => {
                    this.editNotes.title = val.title;
                    this.editNotes.note = val.note;
                });
                this.appNote();
            }).catch(error => {
                $('#editNote').modal('hide');
                Swal.fire('Error!', error.message, 'error');
            });
        },
        async deleteNote() {
            await axios({
                url: '/api/note/' + this.editNotes.id,
                method: 'delete',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#editNote').modal('hide');
                Swal.fire('Success!', result.data.message, 'success');
                this.appNote();
            }).catch(error => {
                $('#editNote').modal('hide');
                Swal.fire('Error!', error.message, 'error');
            });
        }
    }
}
</script>