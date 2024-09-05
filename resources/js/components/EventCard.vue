<template>
  <div class="event-card">
    <h3>{{ event.title }}</h3>
    <p>{{ event.description }}</p>
    <p><strong>Location:</strong> {{ event.location }}</p>
    <p><strong>Start Time:</strong> {{ event.start_time }}</p>
    <p><strong>End Time:</strong> {{ event.end_time }}</p>
    <p><strong>Google Event ID:</strong> {{ event.google_event_id }}</p>
  </div>
</template>

<script>
export default {
  name: 'EventCard',
  props: {
    event: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
.event-card {
  padding: 1em;
  border: 1px solid #ddd;
  margin-bottom: 1em;
  border-radius: 5px;
  background-color: #f9f9f9;
}
h3 {
  margin: 0 0 0.5em;
  color: #333;
}
p {
  margin: 0.5em 0;
}
</style>
