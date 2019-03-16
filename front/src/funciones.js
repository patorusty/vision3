// Funcion de carga de tablas 
export const cargarTabla = {
    created() {
        cargar();
    },
    methods: {
        cargar() {
            HTTP.get('administracion/organizadores/').then(response => {
                this.tableData = response.data.data;
            });
        },
    },
},

// Funcion de creacion 
export const crearItem = {
    methods: {

    },
},

// Funcion Modo Edicion 
export const modoEdicion = {
    methods: {

    },
},

// Funcion de Update 
export const updateItem = {
    methods: {

    },
},

// Funcion de Borrar 
export const borrarItem = {
    methods: {

    },
},

// Funcion Delete 
export const deleteRow = {
    methods: {

    },
},