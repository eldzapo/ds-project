<template>
  <div class="event-card" @click="toggleDescription">
    <h3>{{ event.title }}</h3>
    <p><strong>Start Time:</strong> {{ formatDate(event.start_time) }}</p>
    <p><strong>End Time:</strong> {{ formatDate(event.end_time) }}</p>
    <div class="description-container" :class="{ 'show-description': showDescription }">
      <p class="description">{{ event.description }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { format } from 'date-fns';
import { Event } from '../../types/event';

export default defineComponent({
  name: 'EventCard',
  props: {
    event: {
      type: Object as () => Event,
      required: true,
    },
  },
  data() {
    return {
      showDescription: false,
    };
  },
  methods: {
    formatDate(dateString: string) {
      const date = new Date(dateString);
      return format(date, 'MMMM dd, yyyy');
    },
    toggleDescription() {
      this.showDescription = !this.showDescription;
    },
  },
});
</script>

<style scoped>
.event-card {
  padding: 1.5em;
  border: 1px solid #ddd;
  margin-bottom: 1.5em;
  border-radius: 8px;
  background-color: #ffffff;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease, background-color 0.3s ease;
}

.event-card:hover {
  cursor: pointer;
  background-color: #f0f4f8;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

h3 {
  margin: 0 0 0.5em;
  color: #333;
  font-size: 1.2em;
}

p {
  margin: 0.5em 0;
  color: #666;
}

.description-container {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: #ffffff;
  padding: 1em;
  border-top: 1px solid #ddd;
  transform: translateY(100%);
  transition: transform 0.3s ease, opacity 0.3s ease;
  opacity: 0;
  box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.05);
}

.event-card:hover .description-container,
.event-card.show-description .description-container {
  transform: translateY(0);
  opacity: 1;
}

.description {
  margin: 0;
  color: #444;
}
</style>
