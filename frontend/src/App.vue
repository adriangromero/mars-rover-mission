<template>
  <div id="app-mars-rover">
    <h1 class="title">Mars Rover Mission</h1>
    <div v-if="!apiReady" class="loading">Waiting for API...</div> <!-- Waiting message -->
    <div v-else>
      <form @submit.prevent="sendCommands" class="command-form">
        <div class="form-group-inline">
          <div class="form-group">
            <label for="x">X:</label>
            <input type="number" v-model.number="x" id="x" min="1" max="50" required>
          </div>
          <div class="form-group">
            <label for="y">Y:</label>
            <input type="number" v-model.number="y" id="y" min="1" max="50" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="direction">Direction:</label>
          <select v-model="direction" id="direction" required>
            <option value="N">North</option>
            <option value="E">East</option>
            <option value="S">South</option>
            <option value="W">West</option>
          </select>
        </div>
        
        <div class="form-group">
          <small class="form-text">Indicate the direction you want the rover to move (F: Forward, R: Right, L: Left)</small><br>
          <label for="commands">Commands:</label>
          <input type="text" v-model="commands" id="commands" pattern="[FRL]*" @input="validateCommands" required class="large-input">
        </div>
        
        <button type="submit">Send</button>
      </form>
      
      <div v-if="message" class="message">
        <p>{{ message }}</p>
      </div>
      
      <div v-if="loading" class="loading">Loading...</div> <!-- Loading animation -->
      
      <grid v-if="!loading && obstacles.length > 0" :path="path" :obstacles="obstacles" :gridSize="gridSize" :roverPosition="position" :roverDirection="direction"></grid>
    </div>
  </div>
</template>

<script>
import Grid from './components/Grid.vue';

export default {
  name: 'App',
  components: {
    Grid
  },
  data() {
    return {
      x: 1, // Initialized to 1 to avoid 0
      y: 1, // Initialized to 1 to avoid 0
      commands: '',
      path: [[0, 0]],
      obstacles: [], // Initialized as an empty array
      position: [0, 0],
      direction: 'N',
      message: '',
      gridSize: 50,
      loading: false, // State variable for loading animation
      apiReady: false // State variable to control the visibility of the interface
    };
  },
  methods: {
    async initializeObstacles() {
      this.loading = true; // Start loading animation
      try {
        const response = await this.$api.get('/obstacles');
        if (response.data.error) {
          this.message = response.data.error;
        } else {
          this.obstacles = response.data.obstacles || [];
          if (response.data.gridSize) {
            this.gridSize = response.data.gridSize;
          }
          this.apiReady = true;
        }
      } catch (error) {
        this.message = error.message || 'Error loading obstacles';
      } finally {
        this.loading = false; // Stop loading animation
      }
    },
    async sendCommands() {
      if (this.x === 0 || this.y === 0) {
        this.message = 'X and Y cannot be 0';
        return;
      }

      this.loading = true; // Start loading animation
      try {
        const response = await this.$api.post('/move', {
          x: this.x,
          y: this.y,
          direction: this.direction,
          commands: this.commands,
        });
        if (response.data.error) {
          this.message = response.data.error;
        } else {
          // Update only the values that change
          this.path = response.data.rover.path || [[0, 0]];
          this.obstacles = response.data.rover.obstacles || this.obstacles;
          this.position = response.data.rover.position || [0, 0];
          if (response.data.rover.direction) {
            this.direction = response.data.rover.direction;
          }
          this.message = response.data.rover.statusText || '';
        }
      } catch (error) {
        this.message = error.message || 'An error occurred';
      } finally {
        this.loading = false; // Stop loading animation
      }
    },
    validateCommands(event) {
      const value = event.target.value.toUpperCase();
      const validCommands = /^[FRL]*$/;
      if (!validCommands.test(value)) {
        event.target.value = value.replace(/[^FRL]/g, '');
      }
      this.commands = event.target.value;
    }
  },
  mounted() {
    this.initializeObstacles();
  }
};
</script>

<style scoped src="./assets/css/App.css"></style>
