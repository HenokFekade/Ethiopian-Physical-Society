<template>
    <div class="container">
        
    </div>
</template>

<script>
    export default {
        mounted() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Field Updated Successfuly!',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }
</script>
