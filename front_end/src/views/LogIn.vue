<template>
    <div id="login">
        <div class="container">
            <div class="columns">
                <div class="column col-4 col-sm-10 col-lg-6 col-mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title h5">Log In</div>
                            <div class="card-subtitle text-gray">Kyros</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label" for="input-username">Username</label>
                                <input class="form-input" type="text" spellcheck="false" id="input-username"
                                       placeholder="Username">
                                <label class="form-label" for="input-password">Password</label>
                                <input class="form-input" type="password" id="input-password" placeholder="Password">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button v-on:click="login" class="btn btn-primary">Log In</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LogIn",
        methods: {
            login: function (event) {
                event.preventDefault();
                this.$router.push('/home');
            }
        }
    }
</script>

<style scoped>
    #login {
        padding-top: 5rem;
    }
</style>