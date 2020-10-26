<template>
  <div>
    <div class="row col">
      <h1>Posts</h1>
    </div>

    <div
      v-if="canCreatePost"
      class="row col"
    >
      <form>
        <div class="form-row">
          <div class="col-8">
            <input
              v-model="message"
              type="text"
              class="form-control"
            >
          </div>
          <div class="col-4">
            <button
              :disabled="message.length === 0 || isLoading"
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
  </div>
</template>


