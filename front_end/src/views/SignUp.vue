<template>
    <div id="signup" class="bg-dark">
        <div id="signup-form" class="d-flex align-items-center">
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
                                               placeholder="Username" v-model="input.username">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail">Email</label>
                                        <input type="email" class="form-control" id="inputEmail"
                                               aria-describedby="usernameHelp"
                                               placeholder="Email" v-model="input.email">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword1">Password</label>
                                        <input type="password" class="form-control" id="inputPassword1"
                                               placeholder="Password" v-model="input.password1">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword2">Password confirmation</label>
                                        <input type="password" class="form-control" id="inputPassword2"
                                               placeholder="Password confirmation" v-model="input.password2">
                                    </div>
                                    <button type="submit" v-on:click="signup" class="btn btn-primary">SignUp</button>
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
        name: "SignUp",
        data() {
            return {
                input: {},
                err: false,
                errMsg: '',
            }
        },
        components: {KyrosAlertDanger},
        methods: {
            signup: function (event) {
                event.preventDefault();

                //Format input
                let inputUser = this.inputUser;
                inputUser.api = 1;
                inputUser.k = 12345;
                console.log(inputUser);

                //Request options
                const options = {
                    url: 'https://cse442.dbmxpca.com/register.php',
                    method: 'POST',
                    form: inputUser,
                    json: true
                };

                //Perform request
                const thisReference = this;
                request(options, function (err, res, body) {
                    if (!err && res.statusCode === 200) {
                        if (body.success === false) {
                            thisReference.alert(body.error_message);
                        } else {
                            thisReference.setUser({username: thisReference.input.username});
                            //console.log('Welcome: ' + thisReference.user.username);
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
            inputUser: function () {
                return {
                    username: this.input.username,
                    email: this.input.email,
                    password1: this.input.password1,
                    password2: this.input.password2
                };
            },
            ...mapState(['user'])
        }
    }
</script>

<style scoped>
    #signup {
        height: 100%;
        overflow: scroll;
    }

    #signup-form {
        height: 100%;
    }
</style>