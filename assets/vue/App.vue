<template>
  <div>
    <div class="row col">
      <h1>Posts</h1>
    </div>

    <div class="row col">
      <form>
        <div class="form-row">
          <div class="col-8">
            <input
              v-model="message"
              type="text"
              class="form-control"
            >
            <select
              v-model="post"
              @change="created()"
            >
              <option value="0">
                Select Hotel
              </option>
              <option
                v-for="post in posts" 
                :key="post.id"
                :value="post.id"
              >
                {{ post.name }}
              </option>
            </select>
          </div>
          <div class="col-4">
            <button
              type="button"
              class="btn btn-primary"
              @click="createPost()"
            >
              Create
            </button>
          </div>
        </div>
      </form>
    </div>
   
    <component :is="selectedComponent" />
  </div>
</template>

<script>
import Dashboard from "./components/Dashboard";

export default {
  name: "App",
  components: {
    Dashboard
  },
  data() {
    return {
      message: "",
      hotels:[],
      hotel: ''
    };
  },
  created() {
    this.$store.dispatch("dashboard/findAllHotel");
  },
 
  methods: {
    async createPost() {
      const result = await this.$store.dispatch("dashboard/create", this.$data.message);
      if (result !== null) {
        this.$data.message = "";
      }
    },
    
  }
};
</script>
