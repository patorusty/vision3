<template>
  <div
    class="wrapper"
    :class="{ 'nav-open': $sidebar.showSidebar }"
  >
    <notifications></notifications>
    <sidebar-fixed-toggle-button />
    <side-bar
      :background-color="sidebarBackground"
      :short-title="$t('sidebar.shortTitle')"
      :title="$t('sidebar.title')"
    >
      <template
        slot-scope="props"
        slot="links"
      >
        <sidebar-item :link="{
            name:'home',
            icon: 'tim-icons icon-chart-pie-36',
            path: '/home'
          }"></sidebar-item>
        <sidebar-item :link="{
            name: 'automotor',
            icon: 'tim-icons icon-chart-pie-36',
            path: '/polizas/automotor'
          }"></sidebar-item>
        <sidebar-item :link="{ name: 'Otros Riesgos', icon: 'tim-icons icon-molecule-40' }">
          <sidebar-item :link="{ name: 'Accidente Personal', path: '/otrosriesgos/accidentepersonal' }"></sidebar-item>
          <sidebar-item :link="{ name: 'Combinado Familiar', path: '/otrosriesgos/combinadofamiliar' }"></sidebar-item>
          <sidebar-item :link="{ name: 'otros', path: '/otrosriesgos/otros' }"></sidebar-item>
        </sidebar-item>
        <sidebar-item :link="{
            name: 'siniestros',
            icon: 'tim-icons icon-chart-pie-36',
            path: '/siniestros'
          }"></sidebar-item>
        <sidebar-item :link="{
            name: 'endosos',
            icon: 'tim-icons icon-bullet-list-67',
            path: '/endosos'
          }"></sidebar-item>
        <sidebar-item :link="{
            name: 'clientes',
            icon: 'tim-icons icon-chart-pie-36',
            path: '/clientes'
          }"></sidebar-item>
        <sidebar-item :link="{
            name: 'administracion',
            icon: 'tim-icons icon-components'
          }">
          <sidebar-item :link="{
              name: 'companias',
              path: '/administracion/companias'
            }"></sidebar-item>
          <sidebar-item :link="{
              name: 'organizadores',
              path: '/administracion/organizadores'
            }"></sidebar-item>
          <sidebar-item :link="{
              name: 'productores',
              path: '/administracion/productores'
            }"></sidebar-item>
          <sidebar-item :link="{
              name: 'marca / modelo / version',
              path: '/administracion/marcamodeloversion/edit'
            }"></sidebar-item>
          <sidebar-item :link="{
              name: 'libros rubricados',
              path: '/administracion/librosrubricados'
            }"></sidebar-item>
          <sidebar-item :link="{
              name: 'estadisticas',
              path: '/administracion/estadisticas'
            }"></sidebar-item>
        </sidebar-item>
        <sidebar-item :link="{ name: 'configuracion', icon: 'tim-icons icon-settings-gear-63' }">
          <sidebar-item :link="{ name: 'usuarios', path: '/configuracion/usuarios' }"></sidebar-item>
        </sidebar-item>
      </template>
    </side-bar>
    <div
      class="main-panel"
      :data="sidebarBackground"
    >
      <dashboard-navbar></dashboard-navbar>
      <router-view name="header"></router-view>

      <div
        :class="{ content: !$route.meta.hideContent }"
        @click="toggleSidebar"
      >
        <zoom-center-transition
          :duration="200"
          mode="out-in"
        >
          <!-- your content here -->
          <router-view></router-view>
        </zoom-center-transition>
      </div>
      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<script>
/* eslint-disable no-new */
import PerfectScrollbar from 'perfect-scrollbar';
import 'perfect-scrollbar/css/perfect-scrollbar.css';

function hasElement(className) {
  return document.getElementsByClassName(className).length > 0;
}

function initScrollbar(className) {
  if (hasElement(className)) {
    new PerfectScrollbar(`.${className}`);
  } else {
    // try to init it later in case this component is loaded async
    setTimeout(() => {
      initScrollbar(className);
    }, 100);
  }
}

import DashboardNavbar from './DashboardNavbar.vue';
import ContentFooter from './ContentFooter.vue';
import DashboardContent from './Content.vue';
import SidebarFixedToggleButton from './SidebarFixedToggleButton.vue';
import { SlideYDownTransition, ZoomCenterTransition } from 'vue2-transitions';

export default {
  components: {
    DashboardNavbar,
    ContentFooter,
    SidebarFixedToggleButton,
    DashboardContent,
    SlideYDownTransition,
    ZoomCenterTransition
  },
  data() {
    return {
      sidebarBackground: 'primary' //vue|blue|orange|green|red|primary
    };
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    },
    initScrollbar() {
      let docClasses = document.body.classList;
      let isWindows = navigator.platform.startsWith('Win');
      if (isWindows) {
        // if we are on windows OS we activate the perfectScrollbar function
        initScrollbar('sidebar');
        initScrollbar('sidebar-wrapper');

        docClasses.add('perfect-scrollbar-on');
      } else {
        docClasses.add('perfect-scrollbar-off');
      }
    }
  }
};
</script>
<style lang="scss">
$scaleSize: 0.95;
@keyframes zoomIn95 {
  from {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
  to {
    opacity: 1;
  }
}

.main-panel .zoomIn {
  animation-name: zoomIn95;
}

@keyframes zoomOut95 {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
}

.main-panel .zoomOut {
  animation-name: zoomOut95;
}
</style>
