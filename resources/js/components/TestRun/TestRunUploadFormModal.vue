<template>
  <div>
    <b-modal
      id="uploadModal"
      ref="modal"
      title="Test Run File Upload"
      :hide-footer="true"
      :no-close-on-backdrop="close"
      :no-close-on-esc="close"
      :hide-header-close="close"
    >
      <test-run-form
        @setClose="setClose"
      />
    </b-modal>
  </div>
</template>

<script>
    import TestRunForm from './TestRunForm';

    export default {
        name: 'TestRunUploadFormModal',

        components: {
            TestRunForm
        },

        data() {
            return {
                'close': false
            }
        },
        methods: {
            showForm() {
                this.$refs.modal.show();
            },
            setClose(value) {
                this.close = value;
            }
        }

    }
</script>
