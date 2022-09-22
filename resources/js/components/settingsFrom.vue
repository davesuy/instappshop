<template>

</template>

<script>
    import FormMixin from '../FormMixin';

    export default {
        mixins: [ FormMixin ],

        data() {
            return {
                'action': '/submit',
            }
        }
    }
</script>