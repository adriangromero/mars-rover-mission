<template>
  <div class="container">
    <div class="legend origin-legend">(1, 1)</div>

    <div class="legend grid-size-legend">(50, 50)</div>

    <div class="legend y-legend">Y</div>

    <div class="grid" :style="gridStyle">
      <div v-for="y in gridSize" :key="y" class="row">
        <div
          v-for="x in gridSize"
          :key="x"
          class="cell"
          :class="{ 
            rover: isRoverPosition(x, y), 
            obstacle: isObstaclePosition(x, y),
            path: isPathPosition(x, y),
            start: isStartPosition(x, y)
          }"
        >
          <span v-if="isRoverPosition(x, y)">{{ roverDirection }}</span>
          <span v-else-if="isStartPosition(x, y)">S</span>
        </div>
      </div>
    </div>

    <div class="legend x-legend">X</div>
  </div>
</template>

<script>
export default {
  props: ['path', 'obstacles', 'roverPosition', 'roverDirection', 'gridSize'],
  computed: {
    gridStyle() {
      return {
        gridTemplateColumns: `repeat(${this.gridSize}, 1fr)`,
      };
    },
    containerStyle() {
      const cellSize = 10;
      const gridWidth = this.gridSize * cellSize;
      const gridHeight = this.gridSize * cellSize;
      return {
        width: `${gridWidth}px`,
        height: `${gridHeight}px`,
      };
    },
  },
  methods: {
    isRoverPosition(x, y) {
      return this.roverPosition && this.roverPosition[0] === x && this.roverPosition[1] === y;
    },
    isObstaclePosition(x, y) {
      return this.obstacles && this.obstacles.some(obstacle => obstacle[0] === x && obstacle[1] === y);
    },
    isPathPosition(x, y) {
      return this.path && this.path.some(position => position[0] === x && position[1] === y);
    },
    isStartPosition(x, y) {
      return this.path.length > 0 && this.path[0][0] === x && this.path[0][1] === y;
    }
  }
};
</script>

<style scoped src="../assets/css/Grid.css"></style>