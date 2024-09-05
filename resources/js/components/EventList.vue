<template>
  <div>
    <event-card
      v-for="event in events"
      :key="event.id"
      :event="event"
    ></event-card>
  </div>
</template>

<script>
import EventCard from './EventCard.vue';

export default {
  name: 'EventList',
  components: {
    EventCard,
  },
  props: {
    events: {
      type: Array,
      default: () => [],
    },
  },
  mounted() {
    console.log('Events:', this.events);
  },
};
</script>

<style scoped>
/* Styles for EventList if needed */
</style>
