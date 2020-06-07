export default {
  namespaced: true,
  state: {
    snackbar: false,
    color: "",
    snackText: ""
  },
  mutations: {
    SHOW_SNACK(state, payload) {
      state.snackbar = true;
      state.color = payload.color;
      state.snackText = payload.snackText;
    },
    HIDE_SNACK(state) {
      state.snackbar = false;
    }
  }
};
