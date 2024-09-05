<!-- resources/js/components/App.vue -->
<template>
  <div id="app">
    <header>
      <h1>Dewesoft google app</h1>
    </header>
    <main>
      <event-list :events="events"></event-list>
      <button @click="fetchEvents">Fetch Events</button>
    </main>
  </div>
</template>

<script>
import EventList from './components/EventList.vue';
import { ref } from 'vue';

export default {
  name: 'App',
  components: {
    EventList,
  },
  setup() {
    const events = ref([]);

    const fetchEvents = async () => {
      try {
        const response = await fetch('http://localhost:8000/api/events');
        const data = await response.json();
        events.value = data.events;
        console.log('Fetched events:', events.value);
      } catch (error) {
        console.error('Error fetching events:', error);
      }
    };

    return {
      events,
      fetchEvents,
    };
  },
};
</script>
