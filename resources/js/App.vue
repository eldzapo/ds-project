<!-- resources/js/components/App.vue -->
<template>
  <div id="app">
    <header>
      <h1>Welcome to My Vue App</h1>
    </header>
    <main>
      <example-component></example-component>
      <button @click="fetchEvents">Fetch Events</button>
    </main>
  </div>
</template>

<script>
import ExampleComponent from './components/ExampleComponent.vue';
import { ref } from 'vue';

export default {
  name: 'App',
  components: {
    ExampleComponent,
  },
  setup() {
    const fetchEvents = async () => {
      try {
        const response = await fetch('http://localhost:8000/api/events');
        const data = await response.json();
        console.log(data.events);
      } catch (error) {
        console.error('Error fetching events:', error);
      }
    };

    return {
      fetchEvents,
    };
  },
};
</script>

<style scoped>
#app {
  text-align: center;
  font-family: Arial, sans-serif;
}
header {
  background: #42b983;
  padding: 1em;
  color: white;
}
button {
  margin-top: 1em;
  padding: 0.5em 1em;
  font-size: 1em;
  color: white;
  background-color: #42b983;
  border: none;
  border-radius: 0.3em;
  cursor: pointer;
}
button:hover {
  background-color: #36a17a;
}
</style>
