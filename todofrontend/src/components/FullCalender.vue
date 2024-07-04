<template>
  <div class="todo-app">
    <div class="todo-app-sidebar">
      <div class="todo-app-sidebar-section">
        <h2>Add Todo</h2>
        <form @submit.prevent="addEvent">
          <div class="form-group">
            <label for="event_title">Todo Title</label>
            <input
              type="text"
              id="todo_title"
              class="form-control"
              v-model="newEvent.title"
              required
            />
          </div>
          <div class="form-group">
            <label for="todo_description">Todo Description</label>
            <input
              type="text"
              id="todo_description"
              class="form-control"
              v-model="newEvent.description"
              required
            />
          </div>
          <div class="form-group">
            <label for="todo_color">Todo Color</label>
            <input
              type="color"
              id="todo_color"
              class="form-control"
              v-model="newEvent.color"
              required
            />
          </div>
          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input
              type="date"
              id="start_date"
              class="form-control"
              v-model="newEvent.start"
              required
            />
          </div>
          <div class="form-group">
            <label for="end_date">End Date</label>
            <input
              type="date"
              id="end_date"
              class="form-control"
              v-model="newEvent.end"
              required
            />
          </div>
          <button class="btn btn-secondary mt-3" type="submit">Add Todo</button>
        </form>
        <button class="btn btn-secondary mt-4" type="submit">View Todo</button>
      </div>
      <div class="todo-app-sidebar-section">
        <h2>All Events ({{ currentEvents.length }})</h2>
        <ul>
          <li v-for="event in currentEvents" :key="event.id">
            <b>{{ event.startStr }}</b>
            <i>{{ event.title }}</i>
          </li>
        </ul>
      </div>
    </div>
    <div class="todo-app-main">
      <h1 class="text-center">Todo Calender</h1>
      <FullCalendar class="todo-app-calendar" :options="calendarOptions">
        <template v-slot:eventContent="arg">
          <b>{{ arg.timeText }}</b>
          <i>{{ arg.event.title }}</i>
        </template>
      </FullCalendar>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import axios from "axios";

const calendarOptions = ref({});
const currentEvents = ref([]);
const newEvent = ref({
  title: "",
  description: "",
  color: "",
  start: "",
  end: "",
});
const showModal = ref(false);

const fetchEvents = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/todo");
    currentEvents.value = response.data.data;
    calendarOptions.value.events = currentEvents.value;
  } catch (error) {
    console.error("Error fetching events:", error);
    alert("Failed to fetch events. Please try again.");
  }
};

const handleDateSelect = (selectInfo) => {
  showModal.value = true;
  newEvent.value.start = selectInfo.startStr;
  newEvent.value.end = selectInfo.endStr;
};

const addEvent = async () => {
  try {
    await axios.post("http://localhost:8000/api/todo", newEvent.value);
    fetchEvents();
    showModal.value = false;
    resetForm();
  } catch (error) {
    console.error("Error adding event:", error);
    alert("Failed to add event. Please try again.");
  }
};

const handleEventClick = (clickInfo) => {
  if (
    confirm(
      `Are you sure you want to delete the event '${clickInfo.event.title}'`
    )
  ) {
    clickInfo.event.remove();
  }
};

const handleEvents = (events) => {
  currentEvents.value = events;
};

const resetForm = () => {
  newEvent.value = {
    title: "",
    description: "",
    color: "",
    start: "",
    end: "",
  };
};

onMounted(() => {
  fetchEvents();
});

calendarOptions.value = {
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  headerToolbar: {
    left: "prev,next today",
    center: "title",
    right: "dayGridMonth,timeGridWeek,timeGridDay",
  },
  initialView: "dayGridMonth",
  editable: true,
  selectable: true,
  selectMirror: true,
  dayMaxEvents: true,
  weekends: true,
  select: handleDateSelect,
  eventClick: handleEventClick,
  eventsSet: handleEvents,
};
</script>
<style lang="css">
.todo-app {
  display: flex;
  min-height: 100%;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
  margin: 20px 0;
}

.todo-app-sidebar {
  width: 300px;
  line-height: 1.5;
  background: #f9fbfd;
  border-right: 1px solid #d3e2e8;
  padding: 20px;
}

.todo-app-sidebar-section {
  padding: 1em 0;
}

.todo-app-main {
  flex-grow: 1;
  padding: 3em;
}

.todo-app-calendar {
  max-width: 1100px;
  margin: 0 auto;
}

.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
}

.close {
  float: right;
  font-size: 24px;
  cursor: pointer;
}
</style>
