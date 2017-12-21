<template>
    <div :class="alertSuccess ? 'alert alert-success' : 'alert alert-danger'" role="alert" v-if="isShowAlert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: ['alertSuccess', 'isShowAlert']
    }
</script>