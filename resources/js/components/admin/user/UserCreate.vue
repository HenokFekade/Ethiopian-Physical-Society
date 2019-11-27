<template>
    <div class="container">
        <button @click="ShowCreateUserModal()" class="btn btn-success">
            Add User
        </button>
        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="createUser()">
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Type</label>
                                <select class="custom-select my-1 mr-sm-2 form-control" v-model="form.type"  name="type"
                                     :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="editor" selected>Editor</option>
                                    <option value="chief editor">Chief Editor</option>
                                    <has-error :form="form" field="type"></has-error>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Fields</label><br>
                                <label class="text-danger">Note: need only if it is editor </label>
                                <select multiple class="custom-select my-1 mr-sm-2 form-control" v-model="form.fields"  name="fields"
                                     :class="{ 'is-invalid': form.errors.has('fields') }">
                                    <option  v-for="field in allFields" ::key="field.id" :value="field.name">{{ field.name }}</option>
                                </select>
                                <has-error :form="form" field="fields"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button  type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                allFields: [],
                form: new Form({
                    id: "",
                    name: "",
                    email: "",
                    type: "editor",
                    password: "",
                    fields: [],
                }),
            }
        },

        methods: {
            loadFields() {
                axios.post('/fields/all').then(({data}) => {
                    this.allFields = data;
                }).catch((err) => {
                    
                });
            },

            ShowCreateUserModal() {
                $('#userModal').modal('show');
            },

            createUser() {
                this.form.post('users').then((result) => {
                    this.form.reset();
                    $('#userModal').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'User Added Successfuly!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setInterval(() => {
                                window.location = '/users';
                            }, 1500);
                }).catch((err) => {
                
                });
            }
        },

        mounted() {
                this.loadFields();
              
        }
    }
</script>
