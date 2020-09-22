<template>
  <div class="home">
    <ApolloQuery :query="categoriesQuery">
      <template slot-scope="{ result: { data, loading }, isLoading }">
        <div v-if="isLoading">Loading...</div>
        <div v-else>
          <a href="#" class="link-margin" @click.prevent="selectCategory('all')"
            >All</a
          >
          <a
            href="#"
            class="link-margin"
            @click.prevent="selectCategory('featured')"
            >Featured</a
          >
          <a
            href="#"
            @click.prevent="selectCategory(category.id)"
            v-for="category of data.categories"
            :key="category.id"
            class="link-margin"
          >
            {{ category.id }}
            {{ category.name }}
          </a>
        </div>
      </template>
    </ApolloQuery>
    <!-- <ApolloQuery :query="require('../graphql/queries/Books.gql')">
      <template slot-scope="{ result: { data, loading }, isLoading }">
        <div v-if="isLoading">Loading...</div>
        <div v-else>
          <div v-for="book of data.books" :key="book.id">
            {{ book.title }}
          </div>
        </div>
      </template>
    </ApolloQuery> -->
    <ApolloQuery :query="categoryQuery" :variables="{ id: selectedCategory }">
      <template slot-scope="{ result: { data, loading }, isLoading }">
        <div v-if="isLoading">Loading...</div>
        <div v-else>
          <div v-for="book of data.category.books" :key="book.id">
            {{ book.title }}
          </div>
        </div>
      </template>
    </ApolloQuery>
  </div>
</template>

<script>
// import gql from "graphql-tag";
import categoryQuery from "../graphql/queries/Category.gql";
import booksQuery from "../graphql/queries/Books.gql";
import categoriesQuery from "../graphql/queries/Categories.gql";
import booksFeaturedQuery from "../graphql/queries/BooksByFeatured.gql";
export default {
  name: "Home",
  data() {
    return {
      categoryQuery,
      booksQuery,
      categoriesQuery,
      booksFeaturedQuery,
      query: booksQuery,
      selectedCategory: 1,
    };
  },
  methods: {
    selectCategory(category) {
      if (category == "all") {
        this.query = booksQuery;
      } else if (category == "featured") {
        this.query = booksFeaturedQuery;
      } else {
        this.query = categoryQuery;
      }
      this.selectedCategory = category;
    },
  },
};
</script>

<style>
.link-margin {
  margin-right: 24px;
}
</style>
