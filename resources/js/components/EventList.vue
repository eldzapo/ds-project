<template>
  <div>
    <event-card
      v-for="event in events"
      :key="event.id"
      :event="event"
    ></event-card>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import EventCard from './EventCard.vue';
import { Event } from '../../types/event';

export default defineComponent({
  name: 'EventList',
  components: {
    EventCard,
  },
  props  : {
    events: {
      type: Array as PropType<Event[]>,
      default: () => [],
      required: true,
    },
  },
  mounted() {
    console.log('Events:', this.events);
  },
});
</script>

<style scoped>
div {
  margin: 30px;
}
</style>
