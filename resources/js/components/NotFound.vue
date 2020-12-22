<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex flex-column justify-content-center" style="height: 100vh">
                <div class="text-center">
                    <h1>Oops!</h1>
                    <h3>404 not found!</h3>
                    <div>
                        <span>
                            Sorry, an error has occured, Requested page not found!
                        </span>
                    </div>

                    <div class="mt-3">
                        <router-link class="btn btn-success" to="/">
                            Take me home
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>
