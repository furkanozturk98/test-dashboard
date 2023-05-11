<template>
  <div>
    <b-table
      responsive
      striped
      :busy="busy"
      :items="fetch"
      :fields="fields"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      sort-icon-left
      :current-page="currentPage"
      :per-page="perPage"
    >
      <template v-slot:cell(status)="data">
        <span class="badge" :class="getStatusClass(data.value)">
          {{ getStatusText(data.value) }}
        </span>
      </template>

      <template v-slot:cell(method)="data">
        <p
          v-b-tooltip.hover
          class="method"
          :title="data.value"
        >
          {{ data.value }}
        </p>
      </template>
    </b-table>

    <b-pagination
      v-model="currentPage"
      :total-rows="totalRows"
      :per-page="perPage"
      align="right"
    />
  </div>
</template>

<script>
export default {
    name: 'TestRunDetailsList',

    props: {

        testRunId: {
            type: Number,
            required: true,
        },

    },

    data() {
        return {
            fields: [
                {
                    key: 'status',
                    label: 'Status',
                    sortable: true,
                },
                {
                    key: 'time',
                    label: 'Duration (ms)',
                    class: 'text-right',
                    sortable: true,
                    thStyle: 'width: 120px'
                },
                {
                    key: 'file',
                    label: 'Dosya',
                },
                {
                    key: 'method',
                    label: 'Method',
                },
            ],

            items: [],

            busy: false,

            sortBy: 'duration',
            sortDesc: true,
            totalRows: 0,
            currentPage: 1,
            perPage: 15,
        }
    },

    methods: {
        async fetch(ctx) {
            this.busy = true;

            const sortDir = this.sortDesc ? 'DESC' : '';

            const response = await this.$http.get(`/api/test-run-details/${this.testRunId}?page=${ctx.currentPage}&per_page=${ctx.perPage}&sort=${this.sortBy}&dir=${sortDir}`);

            this.items = response.data.data;
            this.totalRows = response.data.meta.total;

            this.busy = false;

            return this.items;
        },

        getStatusClass(value) {
            const options = [
                'badge-success',
                'badge-danger',
            ];

            return options[value] || 'badge-danger'
        },

        getStatusText(value) {
            const options = [
                'Success',
                'Fail',
                'Error',
            ];

            return options[value] || 'N/A'
        }

    }
}
</script>

<style scoped>
a, a:visited, a:hover, a:focus {
    color: black !important;
    text-decoration: none;
}
</style>
