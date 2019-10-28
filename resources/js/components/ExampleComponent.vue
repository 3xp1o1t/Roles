<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body" v-if="canSeeThisShit">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'can_see_me':false
        },
        data(){
            return {
                user_id: 21 // Este usuario tenemos que extraerlo al componente de alguna manera.
            }
        },
        computed:{
            canSeeThisShit(){
                // return this.authorize(user => this.user_id === user.id);    // Todo el objeto del usuario.
                // return this.authorize(user => this.user_id === user);       // Solo el id del usuario.
                return this.authorize(user => this.can_see_me);
            }
        },
        methods:{

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
