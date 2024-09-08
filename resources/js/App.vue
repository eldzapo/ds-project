<template>
  <div id="app">
    <header>
      <h1>Dewesoft Google App</h1>
    </header>
    <main>
      <div class="content">
        <event-list :events="events"></event-list>
      </div>
      <button @click="fetchEvents" class="fetch-button">Fetch Events</button>
    </main>
  </div>
</template>

<script>
import EventList from './components/EventList.vue';
import { ref } from 'vue';

const API_URL = 'http://localhost:8000/api/do-both'; // Global URL variable

export default {
  name: 'App',
  components: {
    EventList,
  },
  setup() {
    const events = ref([]);

    const fetchEvents = async () => {
      try {
        const response = await fetch(API_URL);
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

<style>
  body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f4f8;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden; 
  }

  #app {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    max-width: 1000px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden; 
  }

  header {
    text-align: center;
    margin: 20px;
  }

  h1 {
    color: #42b983;
    font-size: 28px;
    margin: 0;
  }

  main {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: auto; 
    padding: 20px;
  }

  .content {
    flex: 1; 
    overflow-y: auto;
  }

  .fetch-button {
    background-color: #42b983;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: sticky;
    bottom: 0;
    margin-top: 20px;
    width: calc(100% - 40px); 
  }

  .fetch-button:hover {
    background-color: #35495e;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }
</style>
