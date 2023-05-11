<template>
  <div>
    <div v-if="testRunCount" class="row mb-3">
      <div class="col-md-12">
        <test-runs-by-days />
      </div>
    </div>

    <div v-if="testRunCount" class="row">
      <div class="col-md-12">
        <h4>Test Runs</h4>

        <test-run-list :is-dashboard="true" />
      </div>
    </div>

    <test-run-dashboard-empty v-else class="row" />
  </div>
</template>

<script>
import TestRunsByDays from '../charts/TestRunsByDays';
import TestRunDashboardEmpty from './TestRunDashboardEmpty';
import TestRunList from '../TestRun/TestRunList';

export default {
    name: 'TestRunDashboard',

    components: {
        TestRunsByDays,
        TestRunDashboardEmpty,
        TestRunList
    },

    props:{
      testRunCount:{
          type: Number,
          default: 0
      }
    },

    data() {
        return {
            testRuns: [],
            busy: false,
        }
    }

}
</script>

