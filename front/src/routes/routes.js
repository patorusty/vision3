import DashboardLayout from 'src/pages/Layout/DashboardLayout.vue';
import NotFound from 'src/pages/GeneralViews/NotFoundPage.vue';
// import Home from 'src/pages/Home.vue';

const Home = () => import('src/pages/Home.vue');

// const Automotor = () =>
//   import('src/pages/Automotor.vue');

let otrosRiesgos = {
  path: '/otrosriesgos',
  component: DashboardLayout,
  name: 'Otros Riesgos',
  redirect: '/otrosriesgos/accidentepersonal',
  children: [
    {
      path: 'accidentepersonal',
      name: 'Accidente Personal',
      component: require('../pages/Polizas/HomeAccidentePersonal.vue').default
    },
    {
      path: 'combinadofamiliar',
      name: 'Combinado Familiar',
      component: require('../pages/Polizas/HomeCombinadoFamiliar.vue').default
    },
    {
      path: 'otros',
      name: 'Otros',
      component: require('../pages/Polizas/HomeOtrosRiesgos.vue').default
    }
  ]
};

let administracion = {
  path: '/administracion',
  component: DashboardLayout,
  name: 'Administracion',
  redirect: '/administracion/companias',
  children: [
    {
      path: 'companias',
      name: 'Companias',
      component: require('../pages/Administracion/Companias/Companias.vue')
        .default
    },
    {
      path: 'companias/create',
      name: 'Crear Compañia',
      component: require('../pages/Administracion/Companias/Create.vue').default
    },
    {
      path: 'companias/:nombre/edit',
      name: 'Editar Compania',
      component: require('../pages/Administracion/Companias/Edit.vue').default
    },
    {
      path: 'organizadores',
      name: 'Organizadores',
      component: require('../pages/Administracion/Organizadores/Organizadores.vue')
        .default
    },
    {
      path: 'productores',
      name: 'Productores',
      component: require('../pages/Administracion/Productores/Productores.vue')
        .default
    },
    {
      path: 'marcamodeloversion/edit',
      name: 'Marca Modelo Version',
      component: require('../pages/Administracion/MarcaModeloVersion/Edit.vue')
        .default
    },
    {
      path: 'librosrubricados',
      name: 'libros Rubricados',
      component: require('../pages/Administracion/LibrosRubricados.vue').default
    },
    {
      path: 'estadisticas',
      name: 'Estadisticas',
      component: require('../pages/Administracion/Estadisticas.vue').default
    }
  ]
};

let configuracion = {
  path: '/Configuracion',
  component: DashboardLayout,
  name: 'Configuracion',
  redirect: '/Configuracion/Usuarios',
  children: [
    {
      path: 'usuarios',
      name: 'Usuarios',
      component: require('../pages/Configuracion/Usuarios.vue').default
    }
  ]
};

const routes = [
  {
    path: '/',
    redirect: '/home',
    name: 'Inicio'
  },
  administracion,
  otrosRiesgos,
  configuracion,
  {
    path: '/',
    component: DashboardLayout,
    redirect: '/home',
    name: 'Layout',
    children: [
      {
        path: 'home',
        name: 'Home',
        component: require('../pages/Home.vue').default
      },
      {
        path: '/polizas/automotor',
        component: require('../pages/Polizas/HomeAutomotor.vue').default,
        name: 'Automotor'
      },
      {
        path: '/polizas/create',
        component: require('../pages/Polizas/Create.vue').default,
        name: 'Poliza'
      },
      {
        path: '/polizas/:numero_solicitud/edit',
        component: require('../pages/Polizas/Edit.vue').default,
        name: 'Editar Poliza'
      },
      {
        path: 'siniestros',
        name: 'Siniestros',
        component: require('../pages/Polizas/Siniestros.vue').default
      },
      {
        path: 'endosos',
        name: 'Endosos',
        component: require('../pages/Polizas/Endosos.vue').default
      },
      {
        path: 'clientes',
        name: 'Clientes',
        component: require('../pages/Clientes/Clientes.vue').default
      },
      {
        path: 'clientes/create',
        name: 'Crear Cliente',
        component: require('../pages/Clientes/Create.vue').default
      },
      {
        path: 'clientes/:id/edit',
        name: 'Editar Cliente',
        component: require('../pages/Clientes/Edit.vue').default
      }
    ]
  }
];

export default routes;
