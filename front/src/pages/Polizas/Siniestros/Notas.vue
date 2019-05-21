<template>
  <base-table
    :data="tableData"
    thead-classes="text-primary"
  >
    <template slot-scope="{ row }">
      <td>
        <p class="title">{{ row.title }}</p>
        <p class="text-muted">{{ row.description }}</p>
      </td>
      <td class="td-actions text-right">
        <el-tooltip
          content="Edit task"
          effect="light"
          :open-delay="300"
          placement="top"
        >
          <base-button type="link">
            <i class="tim-icons icon-pencil"></i>
          </base-button>
        </el-tooltip>
      </td>
    </template>
  </base-table>
</template>
<script>
import { BaseTable } from '@/components';

export default {
  components: {
    BaseTable
  },
  data() {
    return {
      tableData: [
        {
          title: 'Update the Documentation',
          description: 'Dwuamish Head, Seattle, WA 8:47 AM',
          done: false
        },
        {
          title: 'GDPR Compliance',
          description:
            'The GDPR is a regulation that requires businesses to protect the personal data and privacy of Europe citizens for transactions that occur within EU member states.',
          done: true
        },
        {
          title: 'Solve the issues',
          description:
            'Fifty percent of all respondents said they would be more likely to shop at a company',
          done: false
        }
      ]
    };
  }
};
</script>
<style></style>
