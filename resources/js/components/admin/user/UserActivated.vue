<template>
    <div class="container">
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
                        axios.get('/users/account-activate/' + this.userId).then(({data}) => {
                            swalWithBootstrapButtons.fire(
                                'Activated!',
                                'User Account Activated.',
                                'success'
                            )
                            window.location = "/home";
                        }).catch((err) => {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'User Account Can\'t Activated!',
                                'error'
                            )
                        })
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'User Account Not Activated!',
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
