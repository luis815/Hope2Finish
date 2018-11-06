<template>
    <div id="LandingPage" class="bg-dark">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <router-link class="navbar-brand" to="/">Kyros</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/signup">SignUp</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/login">LogIn</router-link>
                    </li>
                </ul>
            </div>
        </nav>
        <section id="welcome" class="text-center text-white">
            <div class="container">
                <div class="row">
                    <div class="col-sm d-flex align-items-center">
                        <div id="welcome-msg-wrapper">
                            <h1 class="display-3">Upload your content!</h1>
                            <h3>Connect with your community.</h3>
                        </div>
                    </div>
                    <div class="col-sm">
                        <img src="../assets/welcome.jpg" class="img-thumbnail" alt="Responsive image">
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "LandingPage"
    }
</script>

<style scoped>
    #LandingPage {
        min-height: 100%;
        height: 1px;
        overflow: auto;
    }

    #welcome {
        padding-top: 5em;
        padding-bottom: 5em;
    }

    #welcome img {
        height: 30em;
    }

    #welcome-msg-wrapper {
        padding-bottom: 5em;
    }
</style>