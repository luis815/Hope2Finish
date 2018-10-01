<template>
    <div id="login" class="d-flex align-items-center bg-dark">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                    <div class="card text-left">
                        <div class="card-body">
                            <div class="text-center">
                                <h5 class="card-title">LogIn</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Arkild</h6>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="inputUsername">Username</label>
                                    <input type="text" class="form-control" id="inputUsername"
                                           aria-describedby="usernameHelp"
                                           placeholder="Enter username">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword">Password</label>
                                    <input type="password" class="form-control" id="inputPassword"
                                           placeholder="Password">
                                </div>
                                <button type="submit" v-on:click="login" class="btn btn-primary">LogIn</button>
                            </form>
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
        height: 100%;
        overflow: scroll;
    }
</style>