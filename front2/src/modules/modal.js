export default {
  namespaced: true,
  state: {
    modal: false,
    edicion: false
  },
  mutations: {
    SHOW_MODAL(state, val) {
      state.modal = true;
      state.edicion = val;
    },
    HIDE_MODAL(state, val) {
      state.modal = false;
      state.edicion = val;
    }
  }
};
