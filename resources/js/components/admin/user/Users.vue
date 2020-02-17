<template>
    <div class="container mt-3">
    <vue-progress-bar></vue-progress-bar>
        <div class="row justify-content-center">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users Table</h3>

              <div  class="card-tools">
                  <button class="btn btn-success" @click="ShowCreateUserModal()" >
                    Add New <i class="fas fa-user-plus fw"></i>
                  </button>


                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered  table-hover">
                  <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Fields</th>
                        <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" ::key="user.id">
                      <td>{{ user.count  }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email  }}</td>
                      <td>{{ user.type }}</td>
                      <td>
                        <ul v-for="field in user.fields"  class="style-none">
                            <li ><span class="font-weight-bold mr-3">&#8658;</span>{{ field.name }}</li>
                        </ul>
                      </td>
                      <td >
                        <a href="#" @click="ShowEdetUserModal(user)" class="text-primary">edit<i class="fas fa-edit"></i> </a>
                        /
                        <a href="#" @click="deactivateUser(user.id)" class="text-danger">deactivate<i class="fas fa-lock"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- <div class="card-footer m-auto">
                  <pagination :data="users" @pagination-change-page="getResults"></pagination>
              </div> -->
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editable" class="modal-title" id="userModalLabel">Add User</h5>
                        <h5 v-show="editable" class="modal-title" id="userModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="editable ? editUser() : createUser()">
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
                                <label class="text-danger">Note: this is required only for editors </label>
                                <select multiple class="custom-select my-1 mr-sm-2 form-control" v-model="form.fields"  name="fields"
                                     :class="{ 'is-invalid': form.errors.has('fields') }">
                                    <option  v-for="field in fields" ::key="field.id" :value="field.name">{{ field.name }}</option>
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
                                <button v-if="!editable"  type="submit" class="btn btn-primary">Create</button>
                                <button v-if="editable"  type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
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
                fields: {},
                editable: false,
                users: {},
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
            loadUsers() {
                axios.post('/users/get-all-users').then(({data}) => {
                    this.users = data;
                }).catch((err) => {

                });
            },

            loadFields() {
                axios.post('/fields/get').then(({data}) => {
                    this.fields = data;
                }).catch((err) => {

                });
            },

            ShowCreateUserModal() {
                this.editable = false;
                $('#userModal').modal('show');
                this.form.reset();
            },

            ShowEdetUserModal(user) {
                this.editable = true;
                $('#userModal').modal('show');
                this.form.fill(user);
            },

            createUser() {
                this.$Progress.start();
                this.form.post('users').then(({data}) => {
                    this.form.reset();
                    $('#userModal').modal('hide');
                    if (data == "success") {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'User Added Successfuly!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.$Progress.finish()
                        Fire.$emit('loadUser');
                    }
                    else if (data == "error") {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'User not Add. Because Something went Wrong!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.$Progress.fail();
                    }
                }).catch((err) => {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'User not Add.Because Something went Wrong!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.$Progress.fail();
                });

            },

            editUser() {
                this.$Progress.start()
                this.form.put('users/' + this.form.id).then(({data}) => {
                    this.form.reset();
                    $('#userModal').modal('hide');
                    if (data == "success") {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Updated Successfuly!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.$Progress.finish()
                        Fire.$emit('loadUser');
                    }
                    else if (data == "error") {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'User not Updated. Because Something went Wrong!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.$Progress.fail()
                    }

                }).catch((err) => {
                    console.log(status);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'User not Updated. Because Something went Wrong!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.$Progress.fail()
                });
            },

            deactivateUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "User account will be deactivated!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Deactivated it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start()
                        axios.get('account/account-deactivate/' + id).then(({data}) => {
                            if(data == "success")
                            {
                                Swal.fire(
                                    'Deactivate!',
                                    'The Account Have been Deactivated.',
                                    'success'
                                );
                                this.$Progress.finish()
                                Fire.$emit('loadUser');
                            }
                            else if (data == "error")
                            {
                                Swal.fire(
                                    'error',
                                    'Something Wrong. Please Retry.',
                                    'success'
                                );
                                this.$Progress.fail()
                            }

                        }).catch((err) => {
                            this.$Progress.fail()
                            Swal.fire(
                                'error',
                                'Something Wrong. Please Retry.',
                                'success'
                            );
                        })
                    }
                })
            }
        },

        mounted() {
            this.loadUsers();
            this.loadFields();
            Fire.$on('loadUser', () => {
                this.loadUsers();
            })
        }
    }
</script>
