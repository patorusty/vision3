import http from "../http-request";

const API_URL = '/configuracion/organizadores';

const state = () => ({
    organizadores: [],
    organizador: {
        cuit: "",
        matricula: "",
        activo: true
    }
});
const mutations = {
    SET_ORGANIZADORES(state, organizadores) {
        state.organizadores = organizadores;
    },
    SET_ORGANIZADOR(state, organizador) {
        state.organizador = organizador;
    },
    RESET_ORGANIZADOR(state) {
        state.organizador = Object.assign(
            {},
            {
                cuit: "",
                matricula: "",
                activo: true
            }
        );
    },
    UPDATE_ORGANIZADOR(state, organizador) {
        const item = state.organizadores.find(item => item.id === organizador.id);
        Object.assign(item, organizador);
    },
    CREATE_ORGANIZADOR(state, organizador) {
        state.organizadores.push(organizador);
    },
    DELETE_ORGANIZADOR(state, id) {
        state.organizadores = state.organizadores.filter(u => u.id != id);
    }
};
const actions = {
    async getOrganizadores({ commit }) {
        const resp = await http.load(API_URL);
        commit("SET_ORGANIZADORES", resp.data);
    },

    async getOrganizador({ commit }, id) {
        const resp = await http.loadOne(API_URL, id);
        commit("SET_ORGANIZADOR", resp.data);
    },

    async updateOrganizador({ commit }, organizador) {
        const resp = await http.update(
            API_URL,
            organizador.id,
            organizador
        );
        if (resp.status === 200) {
            commit("UPDATE_ORGANIZADOR", resp.data);
            commit(
                "snackbar/SHOW_SNACK",
                {
                    color: "success",
                    snackText: "Organizador editado con éxito!"
                },
                { root: true }
            );
            return true;
        } else {
            commit(
                "snackbar/SHOW_SNACK"({
                    color: "success",
                    snackText: "Algo salió mal..."
                }),
                { root: true }
            );
        }
    },

    async createOrganizador({ commit }, organizador) {
        const resp = await http.create(API_URL, organizador);
        if (resp.status === 201) {
            commit("CREATE_ORGANIZADOR", resp.data);
            commit(
                "snackbar/SHOW_SNACK",
                {
                    color: "success",
                    snackText: "Organizador creado con éxito!"
                },
                { root: true }
            );
            return true;
        } else {
            commit(
                "snackbar/SHOW_SNACK",
                {
                    color: "red",
                    snackText: "Algo salió mal, intente nuevamente..."
                },
                { root: true }
            );
        }
    },

    async deleteOrganizador({ commit }, id) {
        const resp = await http.delete(API_URL, id);
        if (resp.status === 200) {
            commit("DELETE_ORGANIZADOR", id);
            commit(
                "snackbar/SHOW_SNACK",
                {
                    color: "success",
                    snackText: "Organizador eliminado con éxito!"
                },
                { root: true }
            );
        } else {
            commit(
                "snackbar/SHOW_SNACK"({
                    color: "success",
                    snackText: "Algo salió mal..."
                }),
                { root: true }
            );
        }
    }
};
export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters: {}
};
