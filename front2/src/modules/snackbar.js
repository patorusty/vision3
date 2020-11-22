const state = () => ({
  snackbar: false,
  color: "",
  snackText: ""
})
const mutations = {
  SHOW_SNACK(state, payload) {
    state.snackbar = true;
    state.color = payload.color;
    state.snackText = payload.snackText;
    setTimeout(() => {
      state.snackbar = false;
    }, 3000);
  },
}
export default {
  namespaced: true,
  state,
  mutations,
  getters: {},
};
