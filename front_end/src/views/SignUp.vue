<template>
    <form style="margin: 0 auto;width:60%;min-width:200px;">
        <fieldset>

            <legend><h1>Register A New Account</h1></legend>

            <label>Email Address:</label>
            <input type="text" placeholder="" name="email" size="40" required="">

            <label>Username:</label>
            <input type="text" placeholder="" name="username" size="40" required="">

            <label for="password1">Password:</label>
            <input type="password" placeholder="" id="password1" size="40" required="">

            <label for="password2">Confirm Password:</label>
            <input type="password" placeholder="" id="password2" size="40" required="">

            <button type="submit" v-on:click="login">Create Account</button>

        </fieldset>
    </form>

</template>

<script>
    export default {
        name: "SignUp",
        methods: {
            login: function (event) {
                event.preventDefault();
                this.$router.push('/home');
            }
        }
    }
</script>

<style scoped>
    label {

        display: inline-block;
        float: left;
        clear: left;
        width: 150px;
        text-align: right;
        margin-right: 10px;
    }

    input {

        display: block;
        margin-bottom: 10px;
    }

    button {

        display: inline-block;
        float: right;
        font-weight: bold;
        font-style: normal;
    }

    #error {
        margin: 0 auto;
        margin-top: 10px;
        width: 60%;
        min-width: 200px;
        color: rgb(255, 0, 0);
    }

</style>