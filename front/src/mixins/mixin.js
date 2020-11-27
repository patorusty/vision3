import swal from 'sweetalert2';
import Fuse from 'fuse.js';

export const mixin = {
  computed: {
    queriedData() {
      let result = this.tableData;
      if (this.searchedData.length > 0) {
        result = this.searchedData;
      }
      return result.slice(this.from, this.to);
    },
    to() {
      let highBound = this.from + this.pagination.perPage;
      if (this.total < highBound) {
        highBound = this.total;
      }
      return highBound;
    },
    from() {
      return this.pagination.perPage * (this.pagination.currentPage - 1);
    },
    total() {
      return this.searchedData.length > 0
        ? this.searchedData.length
        : this.tableData.length;
    }
  },
  watch: {
    searchQuery(value) {
      this.fuseSearch = new Fuse(this.tableData, {
        keys: ['nombre', 'apellido'],
        threshold: 0.3
      });
      let result = this.tableData;
      if (value !== '') {
        result = this.fuseSearch.search(this.searchQuery);
      }
      this.searchedData = result;
    }
  },
  data() {
    return {
      pagination: {
        perPage: 5,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50],
        total: 0
      },
      modoEditar: false,
      searchQuery: '',
      propsToSearch: [],
      tableData: [],
      searchedData: [],
      fuseSearch: null,
      isModalVisible: false
    };
  },
  methods: {
    notifyVue(color, mensaje) {
      this.$notify({
        message: mensaje,
        timeout: 3000,
        icon: 'tim-icons icon-bell-55',
        horizontalAlign: 'right',
        verticalAlign: 'top',
        type: color
      });
    },
    dangerSwal() {
      return swal({
        title: 'Estas seguro?',
        text: `Esta acción no se puede revertir!`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success btn-fill',
        cancelButtonClass: 'btn btn-danger btn-fill',
        confirmButtonText: 'Sí, borrar!',
        buttonsStyling: false
      });
    },
    getError(fieldName) {
      return this.errors.first(fieldName);
    }
  }
};
