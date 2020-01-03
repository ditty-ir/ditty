<template>
    <div :id="id" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div v-if="this.$slots.header" class="modal-header">
                    <h4><slot name="header"></slot></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id'],
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
