<template>
  <div class="home">
    <router-link to="/books/add">Add a Book</router-link>
    <ApolloQuery :query="categoriesQuery">
      <template slot-scope="{ result: { data, loading }, isLoading }">
        <div v-if="isLoading">Loading...</div>
        <div v-else>
          <a href="#" class="link-margin" @click.prevent="selectCategory('all')">All</a>
          <a href="#" class="link-margin" @click.prevent="selectCategory('featured')">Featured</a>
          <a
            href="#"
            @click.prevent="selectCategory(category.id)"
            v-for="category of data.categories"
            :key="category.id"
            class="link-margin"
          >{{ category.name }}</a>
        </div>
      </template>
    </ApolloQuery>
    <div v-if="selectedCategory === 'all'">
      <ApolloQuery :query="query">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <div v-else>
            <div v-for="book of data.books" :key="book.id">
              <router-link :to="`/books/${book.id}`">{{book.id}}{{book.title}}</router-link>
              <div>{{book.author}}</div>
              <img :src="book.image" alt="Cover image" />
            </div>
          </div>
        </template>
      </ApolloQuery>
    </div>
    <div v-else-if="selectedCategory==='featured'">
      <ApolloQuery :query="query" :variables="{featured: true}">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <div v-else>
            <div v-for="book of data.booksByFeatured" :key="book.id">
              <router-link :to="`/books/${book.id}`">{{book.id}}{{book.title}}</router-link>
              <div>{{book.author}}</div>
              <img :src="book.image" alt="Cover image" />
            </div>
          </div>
        </template>
      </ApolloQuery>
    </div>
    <div v-else>
      <ApolloQuery :query="query" :variables="{ id: selectedCategory }">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <div v-else>
            <div v-for="book of data.category.books" :key="book.id">
              <router-link :to="`/books/${book.id}`">{{book.id}}{{book.title}}</router-link>
              <div>{{book.author}}</div>
              <img :src="book.image" alt="Cover image" />
            </div>
          </div>
        </template>
      </ApolloQuery>
    </div>
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
      booksQuery,
      booksFeaturedQuery,
      categoryQuery,
      categoriesQuery,
      query: booksQuery,
      selectedCategory: "all",
    };
  },
  methods: {
    selectCategory(category) {
      if (category === "all") {
        this.query = booksQuery;
      } else if (category === "featured") {
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
