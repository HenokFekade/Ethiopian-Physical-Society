<template>
    <div class="container">
        
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log("lislkdfjks");
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Your Account Have Been Updated Successfuly!',
                showConfirmButton: false,
                timer: 2000
            });
        }
    }
</script>
