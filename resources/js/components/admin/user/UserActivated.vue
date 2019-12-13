<template>
    <div class="container">
        <vue-progress-bar></vue-progress-bar>
         <a href="#" @click="accountActivate()" class="text-seccess" >
            activate
            <i class="fas fa-lock-open"></i>
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
                    text: "Do You Want to Activate The Account You Have Seleced?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Activate it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start()
                        axios.get('/account/account-activate/' + this.userId).then(({data}) => {
                            if (data == "success") {
                                swalWithBootstrapButtons.fire(
                                    'Activated!',
                                    'User Account Activated.',
                                    'success'
                                )
                                this.$Progress.finish();
                                window.location = "/home";
                            }
                            else if(data == "error") {
                                this.$Progress.fail();
                                swalWithBootstrapButtons.fire(
                                    'ERROR!',
                                    'User Account Can\'t Activated! Please retry!',
                                    'error'
                                )

                            }
                        }).catch((err) => {
                            this.$Progress.fail();
                            swalWithBootstrapButtons.fire(
                                'ERROR!',
                                'User Account Can\'t Activated! Please retry',
                                'error'
                            )
                        })
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'ERROR!',
                            'User Account Not Activated!',
                            'error'
                        )
                        this.$Progress.fail();
                    }
                    })
            }
        },
        mounted() {

        }
    }
</script>
