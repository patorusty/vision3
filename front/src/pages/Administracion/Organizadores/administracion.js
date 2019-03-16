export const cargarTabla = {
    methods: {
        saludo(vulue) {
            console.log(value);
        },
        cargar(url) {
            HTTP.get(url).then(response => {
                this.tableData = response.data.data;
            });
        },
    },
}