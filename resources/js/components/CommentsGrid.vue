<template>
    <div class="comments-grid">
       <div v-for="(comment, i) in comments" :key="i">
           <div class="comment">
               <p><a class="text-dark" :href="'/profile/'+comment.username"><strong>{{comment.username}}</strong></a> {{comment.comment}}</p>
           </div>
       </div>
       <form class="comment-input d-flex" v-on:submit.prevent="commentPost">
           <input type="text" placeholder="Add a new comment" v-model.lazy="comment">
           <button class="btn btn-text"><i class="fas fa-paper-plane"></i></button>
       </form>
    </div>
</template>

<script>
    export default {
        props: ['postId'],
        mounted() {
            console.log('CommentsGrid component mounted.')
        },
        created() {
           this.getComments(); 
        },
        data: function() {
            return {
                comment: '',
                comments: []
            }
        },
        methods: {
            commentPost() {
                axios.post(`/comment/${this.postId}`, null,  {params: {comment: this.comment}})
                    .then(response => {
                        this.getComments(); 
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            },
            getComments() {
                axios.get(`/comments/${this.postId}`)
                    .then(response => {
                        this.comments = response.data.map((comment) => {
                           return {
                               comment: comment.comment,
                               userId: comment.user_id,
                               postId: comment.post_id,
                               username: comment.username
                           }
                        });
                        console.log(this.comments);
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            }
        }
    }
</script>

<style scoped>

.comments-grid {
    margin: 10px 0;
}

.comments-grid .comment {
    margin: 5px 0;
}

.comments-grid .comment-input input {
    border: none;
    border-bottom: 1px solid #000;
    padding: 10px;
}

</style>