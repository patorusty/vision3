<template>
                  <card>
                <div slot="header">
                  <h4 class="d-inline align-bottom text-primary">COBERTURAS</h4>
                  <base-button
                    type="primary"
                    size="sm"
                    class="float-right"
                    @click="showModalCobertura"
                    >Crear</base-button
                  >
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <el-table :data="coberturasTable">
                      <el-table-column
                        min-width="80"
                        prop="nombre"
                        label="Nombre"
                        align="left"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="antiguedad"
                        label="Antiguedad"
                        align="left"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        align="left"
                        label="Todo Riesgo"
                      >
                        <div slot-scope="{ row }">
                          <div v-if="row.todo_riesgo == true">SI</div>
                          <div v-else>NO</div>
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="franquicia"
                        align="left"
                        label="Franquicia"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="ajuste"
                        align="left"
                        label="Ajuste"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        align="left"
                        label="Activa"
                      >
                        <div slot-scope="{ row }">
                          <div v-if="row.activo == true">SI</div>
                          <div v-else>NO</div>
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        header-align="right"
                        align="right"
                        label="Edicion"
                      >
                        <div
                          slot-scope="props"
                          class="text-right table-actions"
                        >
                          <el-tooltip
                            content="Editar"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              @click.native="handleEdit(props.row.id)"
                              class="edit btn-link"
                              type="warning"
                              size="sm"
                              icon
                            >
                              <i class="tim-icons icon-pencil"></i>
                            </base-button>
                          </el-tooltip>
                          <el-tooltip
                            content="Eliminar"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              @click.native="borrarCob(props.row.id)"
                              class="remove btn-link"
                              type="danger"
                              size="sm"
                              icon
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
</template>
