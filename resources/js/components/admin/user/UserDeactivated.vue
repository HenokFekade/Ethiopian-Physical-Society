<template>
    <div class="container">
        <vue-progress-bar></vue-progress-bar>
         <a href="#" @click="accountActivate()" class="text-danger" >
            deactivate
            <i class="fas fa-lock"></i>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['userId'],
        methods: {
            accountActivate() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger ml-3'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Do You Want to Deactivate The Account You Have Seleced?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Deactivate!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start()
                        axios.get('/account/account-deactivate/' + this.userId).then(({data}) => {
                            if (data == "success") {
                                swalWithBootstrapButtons.fire(
                                    'Deactivated!',
                                    'User Account Deactivated.',
                                    'success'
                                )
                                this.$Progress.finish()
                                window.location = "/home";
                            }
                            else if (data == "error") {
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    'User Account Can\'t Deactivated! Something went wrong!',
                                    'error'
                                )
                                this.$Progress.fail()
                            }

                        }).catch((err) => {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'User Account Can\'t Deactivated! Something went wrong!',
                                'error'
                            )
                            this.$Progress.fail()
                        })
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'User Account Not Deactivated!',
                            'error'
                        )
                    }
                    })
            }
        },
        mounted() {

        }
    }
</script>
