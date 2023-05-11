<template>
  <div>
    <b-navbar type="dark" variant="dark">
      <div class="container">
        <b-navbar-brand href="/">
          {{ appName }}
        </b-navbar-brand>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav>
            <b-nav-item v-if="username" @click="showForm">
              Upload
            </b-nav-item>
          </b-navbar-nav>

          <!-- Right aligned nav items -->
          <b-navbar-nav class="ml-auto">
            <b-nav-item-dropdown v-if="username" right>
              <!-- Using 'button-content' slot -->
              <template v-slot:button-content>
                {{ username }}
              </template>
              <b-dropdown-item @click.prevent="logout">
                Logout
              </b-dropdown-item>
            </b-nav-item-dropdown>
          </b-navbar-nav>
        </b-collapse>
      </div>
    </b-navbar>

    <test-run-upload-form-modal ref="testRunUploadFormModal" />
  </div>
</template>

<script>
    import TestRunUploadFormModal from './TestRun/TestRunUploadFormModal';

    export default {
        name: 'Navbar',
        components: {
            TestRunUploadFormModal
        },
        props: {
            username: {
                type: String,
                default: ''
            },
            appName: {
                type: String,
                default: ''
            },
        },
        methods: {
            logout() {
                try {
                    this.$http.post('/logout');

                    window.location.href = '/login';
                } catch (e) {
                    console.log(e);
                }
            },
            showForm() {
                this.$refs.testRunUploadFormModal.showForm();
            }
        }
    }
</script>

<style scoped>

</style>
