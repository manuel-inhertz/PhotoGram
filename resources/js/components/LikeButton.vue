<template>
    <div>
       <button class="btn btn-light btn-sm ml-3" @click="likePost" v-bind:class="{ liked: postLiked }"><i class="far fa-heart"></i></button> 
    </div>
</template>

<script>
    export default {
        props: ['postId', 'isLiked'],
        mounted() {
            console.log('Component mounted.')
        },
        data: function() {
            return {
                status: this.isLiked,
            }
        },
        methods: {
            likePost() {
                axios.post(`/like/${this.postId}`)
                    .then(response => {
                        this.status =  ! this.status;
                        console.log(response);
                    })
                    .catch(errors => {
                        if(errors.response.status == 401) {
                            window.location = '/login';
                        }
                    })
            }
        },
        computed: {
            postLiked() {
                return (this.status) ? true : false;
            }
        }
    }
</script>

<style scoped>

.liked i {
    font-weight: 900!important;
    color: red;
}

</style>
