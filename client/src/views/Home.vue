<template>
  <div class="home">
    <hero />
    <div class="container text-center lg:text-left">
      <div class="flex flex-wrap -mx-4">
        <div class="w-full lg:w-1/4 px-4 mb-12">
          <ApolloQuery :query="categoriesQuery">
            <template slot-scope="{ result: { data, loading }, isLoading }">
              <div v-if="isLoading">Loading...</div>
              <ul v-else>
                <li class="mb-2">
                  <a
                    href="#"
                    class="text-black hover:text-gray-700"
                    @click.prevent="selectCategory('all')"
                    >All</a
                  >
                </li>
                <li class="mb-2">
                  <a
                    href="#"
                    class="text-black hover:text-gray-700"
                    @click.prevent="selectCategory('featured')"
                    >Featured</a
                  >
                </li>
                <li
                  class="mb-2"
                  v-for="category of data.categories"
                  :key="category.id"
                >
                  <a
                    href="#"
                    @click.prevent="selectCategory(category.id)"
                    class="text-black hover:text-gray-700"
                    >{{ category.name }}</a
                  >
                </li>
                <router-link
                  class="mb-2 text-black hover:text-gray-700"
                  to="/books/add"
                  tag="li"
                >
                  <a>Add a Book</a>
                </router-link>
              </ul>
            </template>
          </ApolloQuery>
        </div>
        <div class="w-full lg:w-3/4 px-4 mb-12">
          <div>
            <ApolloQuery v-if="selectedCategory === 'all'" :query="query">
              <template slot-scope="{ result: { data, loading }, isLoading }">
                <div v-if="isLoading">Loading...</div>
                <div v-else class="flex flex-wrap">
                  <div
                    v-for="book of data.books"
                    :key="book.id"
                    class="w-full md:w-1/2 lg:w-1/3 px-4 mb-12"
                  >
                    <book-listing :book="book" />
                  </div>
                </div>
              </template>
            </ApolloQuery>
            <ApolloQuery
              v-if="selectedCategory === 'featured'"
              :query="query"
              :variables="{ featured: true }"
            >
              <template slot-scope="{ result: { data, loading }, isLoading }">
                <div v-if="isLoading">Loading...</div>
                <div v-else class="flex flex-wrap">
                  <div
                    v-for="book of data.booksByFeatured"
                    :key="book.id"
                    class="w-full md:w-1/2 lg:w-1/3 px-4 mb-12"
                  >
                    <book-listing :book="book" />
                  </div>
                </div>
              </template>
            </ApolloQuery>
            <ApolloQuery
              v-if="
                selectedCategory !== 'featured' && selectedCategory !== 'all'
              "
              :query="query"
              :variables="{ id: selectedCategory }"
            >
              <template slot-scope="{ result: { data, loading }, isLoading }">
                <div v-if="isLoading">Loading...</div>
                <div v-else class="flex flex-wrap">
                  <div
                    v-for="book of data.category.books"
                    :key="book.id"
                    class="w-full md:w-1/2 lg:w-1/3 px-4 mb-12"
                  >
                    <book-listing :book="book" />
                  </div>
                </div>
              </template>
            </ApolloQuery>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import gql from "graphql-tag";
import categoryQuery from "../graphql/queries/Category.gql";
import booksQuery from "../graphql/queries/Books.gql";
import categoriesQuery from "../graphql/queries/Categories.gql";
import booksFeaturedQuery from "../graphql/queries/BooksByFeatured.gql";
import hero from "../components/Hero";
import bookListing from "../components/BookListing";
export default {
  name: "Home",
  components: { bookListing, hero },
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
