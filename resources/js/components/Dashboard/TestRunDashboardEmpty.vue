<template>
  <div class="col-md-8 mx-auto">
    <div class="row">
      <div class="col-md-12 text-center">
        <b-alert show>
          You have no test runs. Upload your first file
        </b-alert>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <test-run-form />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'TestRunDashboardEmpty',
}
</script>
