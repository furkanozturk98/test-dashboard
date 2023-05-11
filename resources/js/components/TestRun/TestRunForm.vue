<template>
  <div>
    <b-form @submit.prevent="submit">
      <b-form-group
        label-for="title"
        :invalid-feedback="form.errors.first('title')"
      >
        <b-form-input
          id="title"
          v-model="form.title"
          :state="form.errors.has('title') ? false : null"
          placeholder="Enter title"
        />
      </b-form-group>

      <b-form-group
        label-for="file"
        :invalid-feedback="form.errors.first('file')"
      >
        <b-form-file
          id="file"
          v-model="form.file"
          :state="form.errors.has('file') ? false : null"
          placeholder="Choose a file or drop it here..."
          drop-placeholder="Drop file here..."
          accept=".xml"
        />
      </b-form-group>
      <b-button type="submit" variant="primary" :disabled="disabled" style="float: right">
        {{ buttonText }}
      </b-button>
    </b-form>
  </div>
</template>

<script>
import Form from 'form-backend-validation';

export default {
        name: 'TestRunForm',

        data() {
            return {
                form : new Form({
                    title : null,
                    file : null
                }),

                disabled: false,
                buttonText: 'Upload'
            }
        },

        methods: {
            async submit() {
                this.disabled = true;

                this.$emit('setClose',true);

                this.buttonText = 'Uploading...';

                try{
                    await this.form.post('/api/test-runs');

                    this.$bvToast.toast('Test run file uploaded successfully', {
                        title: 'Success',
                        autoHideDelay: 1000,
                        variant : 'success'
                    });

                    this.$emit('setClose',false);

                    window.location='/';

                }
                catch (e) {
                    this.disabled = false;

                    this.buttonText = 'Upload';

                    this.$emit('setClose',false);
                }
            }
        }
    }
</script>
