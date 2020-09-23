<template>
  <div class="create container mt-12">
    <h1 class="text-2xl mb-2">Create Book</h1>
    <form
      action="#"
      method="post"
      @submit.prevent="addBook"
      class="w-full max-w-lg"
      autocomplete="off"
    >
      <div class="form-group">
        <label
          for="title"
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          >Title</label
        >
        <input
          type="text"
          name="title"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          id="title"
          autofocus
          v-model="title"
        />
      </div>
      <div class="form-group">
        <label
          for="author"
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          >Author</label
        >
        <input
          type="text"
          name="author"
          id="author"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          v-model="author"
        />
      </div>
      <div class="form-group">
        <label
          for="image"
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          >Image</label
        >
        <input
          type="text"
          name="image"
          id="image"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          v-model="image"
        />
      </div>
      <div class="form-group">
        <label
          for="description"
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          >Description</label
        >
        <textarea
          type="text"
          name="description"
          id="description"
          cols="30"
          rows="10"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          v-model="description"
        ></textarea>
      </div>
      <div class="form-group">
        <label
          for="link"
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          >Link</label
        >
        <input
          type="text"
          name="link"
          id="link"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          v-model="link"
        />
      </div>
      <div class="mt-2">
        <label class="inline-flex items-center">
          <input
            type="checkbox"
            name="featured"
            class="form-checkbox"
            v-model="featured"
          />
          <span class="ml-2">
            Featured
          </span>
        </label>
      </div>
      <div class="form-group">
        <ApolloQuery :query="require('../graphql/queries/Categories.gql')">
          <template slot-scope="{ result: { data, loading }, isLoading }">
            <div v-if="isLoading">Loading...</div>
            <select
              name="category"
              id="category"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
              v-model="category_id"
              v-else
            >
              <option
                v-for="category of data.categories"
                :key="category.id"
                :value="category.id"
                >{{ category.name }}</option
              >
            </select>
          </template>
        </ApolloQuery>
      </div>
      <div class="form-group">
        <button type="submit">Add Book</button>
      </div>
    </form>
  </div>
</template>

<script>
import addBook from "../graphql/mutations/AddBook.gql";
export default {
  data() {
    return {
      title: "",
      author: "",
      image: "",
      description: "",
      link: "",
      featured: false,
      category_id: 1,
    };
  },
  methods: {
    addBook() {
      const newTag = this.newTag;
      this.newTag = "";
      this.$apollo
        .mutate({
          mutation: addBook,
          variables: {
            title: this.title,
            author: this.author,
            image: this.image,
            description: this.description,
            link: this.link,
            featured: this.featured,
            category_id: this.category_id,
          },
        })
        .then((data) => {
          console.log(data);
          this.$router.push("/");
        })
        .catch((error) => {
          console.error(error);
          this.newTag = newTag;
        });
    },
  },
};
</script>

<style scoped>
.form-group {
  margin-bottom: 32px;
}
label {
  margin-right: 10px;
}
input[type="text"],
textarea {
  padding: 10px 14px;
  border: 1px solid lightgray;
  border-radius: 5px;
}
button {
  padding: 16px;
  background: #027bff;
  color: white;
  border-radius: 5px;
  font-size: 16px;
}
</style>
