<template>
    <div>
        <div class="card card-primary">
            <div class="card-header">
                <h4><slot name="header"></slot></h4>
            </div>
            <div class="card-body">
                <slot name="body"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
