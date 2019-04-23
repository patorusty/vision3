<template>
  <div class="col-md-12">
    <card class="mt-4 ">
      <div
        class="col-sm-12 row align-items-center"
        slot="header"
      >
        <div class="col">
          <h4 class="d-inline text-primary ">DETALLE DEL RIESGO</h4>
        </div>
        <div class="col">
          <base-button
            type="primary"
            size="sm"
            class=" d-inline float-right "
          >Agregar</base-button>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <el-table>
            <el-table-column
              min-width="80"
              align="left"
              label="Tipo"
              v-model="riesgo_automotor.automotor_tipo"
            >
            </el-table-column>
            <el-table-column
              min-width="150"
              prop=""
              label="Marca / Modelo / Version"
              align="left"
              v-model="riesgo_automotor.automotor_marca"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              prop=""
              label="Patente"
              align="left"
              v-model="riesgo_automotor.patente"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              align="left"
              label="Suma Asegurada"
              v-model="riesgo_automotor.valor_total"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              align="left"
              label="Cobertura"
              v-model="riesgo_automotor.cobertura_id"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              align="left"
              label="Franquicia"
              v-model="riesgo_automotor.franquicia"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              header-align="right"
              align="left"
              label="Edicion"
            >
              <div
                slot-scope="{
                  row,
                  $index
                }"
                class="text-right table-actions"
              >
                <el-tooltip
                  content="Refresh"
                  effect="light"
                  :open-delay="300"
                  placement="top"
                >
                  <base-button
                    :type="$index > 2 ? 'success' : 'neutral'"
                    icon
                    size="sm"
                    class="btn-link"
                  >
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
                </el-tooltip>
                <el-tooltip
                  content="Delete"
                  effect="light"
                  :open-delay="300"
                  placement="top"
                >
                  <base-button
                    :type="$index > 2 ? 'danger' : 'neutral'"
                    icon
                    size="sm"
                    class="btn-link"
                  >
                    <i class="tim-icons icon-simple-remove"></i>
                  </base-button>
                </el-tooltip>
              </div>
            </el-table-column>
          </el-table>
        </div>
      </div>
    </card>
  </div>
</template>
<script>
import axios from 'axios';
import { Table, TableColumn } from 'element-ui';

export default {};
</script>

