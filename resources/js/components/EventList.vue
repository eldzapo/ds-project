<template>
  <div v-if="sortedEvents.length > 0" class="event-list">
    <event-card
      v-for="event in sortedEvents"
      :key="event.id"
      :event="event"
    ></event-card>
  </div>
  <p v-else class="no-events">No events available.</p>
</template>

<script lang="ts">
import { defineComponent, PropType, computed } from 'vue';
import EventCard from './EventCard.vue';
import { Event } from '../../types/event';

export default defineComponent({
  name: 'EventList',
  components: {
    EventCard,
  },
  props: {
    events: {
      type: Array as PropType<Event[]>,
      default: () => [],
      required: true,
    },
  },
  setup(props) {
    const sortedEvents = computed(() => {
      return [...props.events].sort((a, b) => {
        return new Date(b.start_time).getTime() - new Date(a.start_time).getTime();
      });
    });

    return {
      sortedEvents,
    };
  },
});
</script>

<style scoped>
.event-list {
  display: flex;
  flex-direction: column;
  gap: 1.5em;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.no-events {
  text-align: center;
  font-size: 1.2em;
  color: #666;
  margin: 20px;
}
</style>
