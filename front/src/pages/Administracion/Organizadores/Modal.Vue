<template>
  <modal
    :show.sync="modal.organizadores"
    headerClasses="justify-content-center"
  >
    <h4
      slot="header"
      class="title title-up"
    >Modal title</h4>
    <p>
      Far far away, behind the word mountains, far from the countries
      Vokalia and Consonantia, there live the blind texts. Separated
      they live in Bookmarksgrove right at the coast of the Semantics,
      a large language ocean. A small river named Duden flows by their
      place and supplies it with the necessary regelialia. It is a
      paradisematic country, in which roasted parts of sentences fly
      into your mouth.
    </p>
    <template slot="footer">
      <base-button>Nice Button</base-button>
      <base-button
        type="danger"
        @click.native="modals.classic = false;"
      >Close
      </base-button>
    </template>
  </modal>
</template>
<script>
import { Modal, BaseAlert } from 'src/components';
export default {
  components: {
    Modal,
    BaseAlert
  },
  data() {
    return {
      
  }
};
</script>
