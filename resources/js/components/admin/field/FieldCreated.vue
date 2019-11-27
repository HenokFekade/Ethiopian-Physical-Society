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
                title: 'Field Added Successfuly!',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }
</script>
