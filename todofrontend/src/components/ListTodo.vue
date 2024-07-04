<template>
  <div class="container">
    <h2>Todo List</h2>
    <div v-if="todos.length === 0">
      <p>No todos found.</p>
    </div>
    <div>
      <table class="table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Color</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="todo in todos" :key="todo.id">
            <td>{{ todo.title }}</td>
            <td>{{ todo.description }}</td>
            <td>
              <span>{{ todo.color }}</span>
            </td>
            <td>{{ todo.start }}</td>
            <td>{{ todo.end }}</td>
            <td>
              <button
                class="btn btn-sm btn-danger"
                @click="deleteTodo(todo.id)"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      todos: [],
    };
  },
  created() {
    this.fetchTodos();
  },
  methods: {
    fetchTodos() {
      axios
        .get("http://localhost:8000/api/todo")
        .then((response) => {
          this.todos = response.data.data;
          console.log(response.data);
        })
        .catch((error) => {
          console.error("Error fetching todos:", error);
        });
    },
    deleteTodo(id) {
      axios
        .delete(`http://localhost:8000/api/todo/${id}`) // Replace with your API endpoint
        .then((response) => {
          console.log("Todo deleted:", id);
          this.fetchTodos(); // Refresh the todo list after deletion
        })
        .catch((error) => {
          console.error("Error deleting todo:", error);
        });
    },
  },
};
</script>

<style scoped></style>
