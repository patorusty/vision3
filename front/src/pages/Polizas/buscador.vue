 <!-- <div class="row">
                  <div class="col-md-4">
                    <label>Asegurado:</label>
                    <el-select
                      filterable
                      name="cliente_id"
                      class="select-primary"
                    >
                      <el-option
                        v-for="cliente in clientes"
                        class="select-primary"
                        :key="cliente.id"
                        :value="cliente.id"
                        :label="
                                cliente.apellido +
                                  ' ' +
                                  cliente.nombre +
                                  ' | DNI: ' +
                                  cliente.nro_dni
                              "
                      ></el-option>
                    </el-select>
                  </div>
                  <div class="col-md-3">
                    <base-input>
                      <label>Poliza N:</label>
                      <el-input
                        type="search"
                        class="search-input"
                        clearable
                        prefix-icon="el-icon-search"
                        placeholder="Buscar"
                        aria-controls="datatables"
                      ></el-input>
                    </base-input>
                  </div>
                  <div class="col-md-3">
                    <base-input>
                      <label>Patente:</label>
                      <el-input
                        type="search"
                        class="search-input"
                        clearable
                        prefix-icon="el-icon-search"
                        placeholder="Buscar"
                        aria-controls="datatables"
                      ></el-input>
                    </base-input>
                  </div>
                </div>
                <collapse>
                  <collapse-item
                    title="Busqueda avanzada"
                    class="style=padding:0px"
                  >
                    <div class="row">
                      <div class="col-md-3">
                        <label>Compañia</label>
                        <el-select
                          name="compania"
                          class="select-primary"
                          filterable
                        >
                          <el-option
                            class="select-primary"
                            v-for="compania in companias"
                            :key="compania.id"
                            :value="compania.nombre"
                            :label="compania.nombre"
                          ></el-option>
                        </el-select>
                      </div>
                      <div class="col-md-3">
                        <label>Estado:</label>
                        <el-select
                          name="estado"
                          class="select-primary"
                          filterable
                        >
                          <el-option
                            class="select-primary"
                            v-for="estado in estados"
                            :key="estado.id"
                            :value="estado.nombre"
                            :label="estado.nombre"
                          ></el-option>
                        </el-select>
                      </div>

                      <div class="col-md-3">
                        <label>Forma de Pago:</label>
                        <el-select
                          name="forma_pagos"
                          class="select-primary"
                          filterable
                        >
                          <el-option
                            class="select-primary"
                            v-for="formapago in forma_pagos"
                            :key="formapago.id"
                            :value="formapago.nombre"
                            :label="formapago.nombre"
                          ></el-option>
                        </el-select>
                      </div>
                    </div>
                  </collapse-item>
                </collapse>
                <div class="botonbuscar">
                  <base-button type="primary">Buscar
                  </base-button>
                </div>
              </div> -->