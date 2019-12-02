<template>
    <div class="container">
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
                    confirmButtonText: 'Yes, Deactivate it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        axios.get('/users/account-deactivate/' + this.userId).then(({data}) => {
                            swalWithBootstrapButtons.fire(
                                'Activated!',
                                'User Account Deactivated.',
                                'success'
                            )
                            window.location = "/home";
                        }).catch((err) => {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'User Account Can\'t Deactivated!',
                                'error'
                            )
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
