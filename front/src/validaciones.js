export default {
  custom: {
    nombre: {
      required: 'Este campo es obligatorio'
    },
    apellido: {
      required: 'Este campo es obligatorio'
    },
    email: {
      required: 'Este campo es obligatorio',
      email: 'El formato no es válido'
    },
    cuit: {
      required: 'Este campo es obligatorio',
      numeric: 'Este campo debe ser numerico',
      max: 'Este campo no puede tener mas de 11 numeros',
      min: 'Este campo no puede tener menos de 11 numeros'
    },
    telefono_1: {
      numeric: 'Este campo debe ser numerico'
    },
    telefono_2: {
      numeric: 'Este campo debe ser numerico'
    },
    matricula: {
      required: 'Este campo es obligatorio',
      numeric: 'Este campo debe ser numerico'
    },
    email_siniestros: {
      required: 'Este campo es obligatorio'
    },
    email_emision: {
      required: 'Este campo es obligatorio'
    },
    codigo_organizador: {
      required: 'Este campo es obligatorio'
    },
    organizador_id: {
      required: 'Este campo es obligatorio'
    },
    codigo_productor: {
      required: 'Este campo es obligatorio'
    },
    productor_id: {
      required: 'Este campo es obligatorio'
    },
    codigo_organizador_id: {
      required: 'Este campo es obligatorio'
    },
    nro_dni: {
      required: 'Este campo es obligatorio',
      numeric: 'Este campo debe ser numerico'
    },
    direccion: {
      required: 'Este campo es obligatorio'
    },
    direccion_nro: {
      required: 'Este campo es obligatorio'
    },
    celular: {
      required: 'Este campo es obligatorio'
    },
    premio: {
      required: 'Este campo es obligatorio'
    },
    comision: {
      required: 'Este campo es obligatorio'
    },
    cantidad_cuotas: {
      required: 'Este campo es obligatorio'
    },
    petente: {
      required: 'Este campo es obligatorio'
    },
    nro_motor: {
      required: 'Este campo es obligatorio'
    },
    nro_chasis: {
      required: 'Este campo es obligatorio'
    },
    valor_vehiculo: {
      required: 'Este campo es obligatorio'
    }
  }
};
