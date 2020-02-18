<template>
    <div class="container">
        <a href="#" class="text-danger" @click="warning(fileId)"> 
            reject 
            <i class="nav-icon fas fa-reply fw  "></i>
        </a>
       
    </div>
</template>

<script>
    export default {
        props: ['fileId'],

        methods: {
            warning(id)
            {
               Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Reject!'
                }).then((result) => {
                    if (result.value) {
                        axios.get('file/reject/'+id).then( () => {
                            Swal.fire(
                                'Rejected!',
                                'The Tesis is Rejected.',
                                'success'
                            );
                            setInterval(() => {
                                window.location = '/home';
                            }, 3000);
                        }).catch( () => {
                            Swal.fire(
                                'Failed!',
                                'Failed to Reject.',
                                'error'
                            )
                        }) 
                    }
                });

            }
        },

        created() {
            
        }
    }
</script>