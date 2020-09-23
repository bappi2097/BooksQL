<template>
  <div class="book container">
    <ApolloQuery
      :query="require('../graphql/queries/Book.gql')"
      :variables="{ id: $route.params.id }"
    >
      <template slot-scope="{ result: { data, loading }, isLoading }">
        <div v-if="isLoading">Loading...</div>
        <div v-else class="flex mt-16 flex-col lg:flex-row">
          <div>
            <img :src="data.book.image" alt="book cover" />
          </div>
          <div class="w-full lg:w-2/3 ml-0 mt-8 lg:mt-0 lg:ml-10">
            <div class="text-4xl font-bold">{{ data.book.title }}</div>
            <div class="text-2xl text-gray-700 mb-3">
              {{ data.book.author }}
            </div>
            <div class="text-lg text-gray-600 leading-normal">
              {{ data.book.description }}
            </div>
            <div class="my-12">
              <a
                :href="data.book.link"
                class="border border-purple-600 border-solid rounded text-purple-600 px-4 py-4 hover:bg-purple-600 hover:text-white"
                >View Link</a
              >
            </div>
            <router-link
              :to="`/books/${data.book.id}/edit`"
              class="mr-2 hover:text-gray-600"
              >Edit</router-link
            >
            <a
              href="#"
              class="mr-2 hover:text-gray-600"
              @click.prevent="deleteBook()"
              >Delete</a
            >
          </div>
        </div>
      </template>
    </ApolloQuery>
  </div>
</template>

<script>
import deleteBook from "../graphql/mutations/DeleteBook.gql";
export default {
  methods: {
    deleteBook(book) {
      this.$apollo
        .mutate({
          mutation: deleteBook,
          variables: {
            id: this.$route.params.id,
          },
        })
        .then((data) => {
          this.$router.push("/");
        });
    },
  },
};
</script>
