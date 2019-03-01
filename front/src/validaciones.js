export default {
  custom: {
    nombre: {
      required: 'Este campo es obligatorio'
    },
    cuit: {
      required: 'Este campo es obligatorio',
      numeric: 'Este campo debe ser numerico',
      max: 'Este campo no puede tener mas de 11 numeros',
      min: 'Este campo no puede tener menos de 11 numeros'
    }
  }
};
