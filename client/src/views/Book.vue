<template>
  <div class="book">
    <ApolloQuery
      :query="require('../graphql/queries/Book.gql')"
      :variables="{id: $route.params.id}"
    >
      <template slot-scope="{ result: { data, loading }, isLoading }">
        <div v-if="isLoading">Loading...</div>
        <div v-else>
          <div>{{data.book.title}}</div>
          <div>{{data.book.author}}</div>
          <!-- <div>{{data.book.description}}</div> -->
          <img :src="data.book.image" alt="cover page" />
          <!-- <div>{{data.book.}}</div> -->
          <div>
            <router-link :to="`/books/${data.book.id}/edit`" class="link-margin">Edit</router-link>
            <a href="#" class="link-margin" @click.prevent="deleteBook()">Delete</a>
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