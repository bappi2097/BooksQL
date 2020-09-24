<template>
  <div class="create container mt-12">
    <h1 class="text-2xl mb-2">Edit Book</h1>
    <form
      action="#"
      method="post"
      @submit.prevent="editBook"
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
          id="title"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          v-model="title"
          autofocus
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
      <div class="form-group">
        <label>
          <input type="checkbox" name="featured" v-model="featured" /> Featured
        </label>
      </div>
      <div class="form-group">
        <ApolloQuery :query="require('../graphql/queries/Categories.gql')">
          <template slot-scope="{ result: { data, loading }, isLoading }">
            <div v-if="isLoading">Loading...</div>
            <select
              name="category"
              id="category"
              v-model="category_id"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
              v-else
            >
              <option
                v-for="category of data.categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </template>
        </ApolloQuery>
      </div>
      <div class="form-group">
        <button type="submit">Update Book</button>
      </div>
    </form>
  </div>
</template>

<script>
import updateBook from "../graphql/mutations/UpdateBook.gql";
import book from "../graphql/queries/Book.gql";
export default {
  data() {
    return {
      id: this.$route.params.id,
      title: "",
      author: "",
      image: "",
      description: "",
      link: "",
      featured: false,
      category_id: "",
      book: null,
    };
  },
  apollo: {
    book: {
      query: book,
      variables() {
        if (this.$route && this.$route.params) {
          return {
            id: this.$route.params.id,
          };
        }
      },
      result({ data, loading, networkStatus }) {
        this.title = data.book.title;
        this.author = data.book.author;
        this.description = data.book.description;
        this.link = data.book.link;
        this.image = data.book.image;
        this.featured = data.book.featured;
        this.category_id = data.book.category.id;
      },
    },
  },
  methods: {
    editBook() {
      this.$apollo
        .mutate({
          mutation: updateBook,
          variables: {
            id: this.id,
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
          this.category_id = data.data.updateBook.category.id;
          this.$router.push(`/books/${this.id}`);
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>

<style scoped>
.form-group {
  margin-bottom: 32px;
}
input[type="text"] {
  padding: 10px 14px;
}
button {
  padding: 16px;
  background: #027bff;
  color: white;
  border-radius: 5px;
  font-size: 16px;
}
</style>
