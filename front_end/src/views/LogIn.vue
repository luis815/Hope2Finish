<template>
    <div id="login" class="bg-dark">
        <div id="login-form" class="d-flex align-items-center ">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-auto">
                        <div class="card text-left">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="card-title">LogIn</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Kyros</h6>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label for="inputUsername">Username</label>
                                        <input type="text" class="form-control" id="inputUsername"
                                               aria-describedby="usernameHelp"
                                               placeholder="Enter username" v-model="input.username">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword">Password</label>
                                        <input type="password" class="form-control" id="inputPassword"
                                               placeholder="Password" v-model="input.password">
                                    </div>
                                    <button type="submit" v-on:click="login" class="btn btn-primary">LogIn</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <kyros-alert-danger v-show="err" :msg="errMsg"/>
    </div>
</template>

<script>
    import request from 'request'
    import {mapState, mapMutations} from 'vuex'
    import KyrosAlertDanger from '../components/KyrosAlertDanger.vue'

    export default {
        name: "LogIn",
        data() {
            return {
                input: {},
                err: false,
                errMsg: ''
            }
        },
        components: {KyrosAlertDanger},
        methods: {
            login: function (event) {
                event.preventDefault();

                //Format input
                let inputUser = this.inputUser;
                inputUser.api = 1;
                inputUser.k = 12345;

                //Request options
                const options = {
                    url: 'https://cse442.dbmxpca.com/login.php',
                    method: 'POST',
                    form: inputUser,
                    json: true
                };

                //Perform request
                const thisReference = this;
                request(options, function (err, res, body) {
                    if (!err && res.statusCode === 200) {
                        if (body.success === false) {
                            thisReference.alert(body.error_message_frontend);
                        } else {
                            thisReference.setUser({username: thisReference.input.username});
                            thisReference.$router.push('/home');
                        }
                    } else {
                        thisReference.alert('Internal error.');
                    }
                });
            },
            alert: function (errMsg) {
                this.errMsg = errMsg;
                this.err = true;
                let thisReference = this;
                setTimeout(function () {
                    thisReference.err = false;
                }, 3000);
            },
            ...mapMutations(['setUser'])
        },
        computed: {
            inputUser() {
                return {
                    username: this.input.username,
                    password: this.input.password
                }
            },
            ...mapState(['user'])
        },
        created() {
            if(this.user.username !== undefined) {
                this.$router.push('/home');
            }
        }
    }
</script>

<style scoped>
    #login {
        min-height: 100%;
        height: 1px;
        overflow: auto;
    }

    #login-form {
        height: 100%;
    }
</style>