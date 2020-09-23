<template>
  <div class="home">
    <div class="hero bg-gray-100 mb-24">
      <div class="container flex justify-between py-10">
        <div class="mt-10">
          <h1 class="text-3xl w-3/4 mb-4">
            Book Recommendation site built with GraphQL
          </h1>
          <p class="leading-normal w-3/4 mb-6">
            Built with Laravel (LightHouse GraphQL), Vue.js (vue-apollo) and
            Tailwind CSS
          </p>
          <div class="flex items-center">
            <a
              href="#"
              class="bg-purple-600 text-white rounded px-4 py-4 mr-4 hover:bg-purple"
              >View Books</a
            >
            <a
              href="#"
              class="border border-purple-600 border-solid rounded text-purple-600 px-4 py-4 hover:bg-purple-600 hover:text-white"
              >View Screencasts</a
            >
          </div>
        </div>
        <div>
          <img src="../assets/hero.svg" alt="hero image" />
        </div>
      </div>
    </div>

    <!-- end hero -->
    <div class="container">
      <div class="flex flex-wrap -mx-4">
        <div class="w-1/4 px-4 mb-12">
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
        <div class="w-3/4 px-4 mb-12">
          <div>
            <ApolloQuery :query="query" v-if="selectedCategory === 'all'">
              <template slot-scope="{ result: { data, loading }, isLoading }">
                <div v-if="isLoading">Loading...</div>
                <div v-else class="flex flex-wrap">
                  <div
                    v-for="book of data.books"
                    :key="book.id"
                    class="w-1/3 px-4 mb-12"
                  >
                    <router-link :to="`/books/${book.id}`">
                      <img
                        :src="book.image"
                        alt="Cover image"
                        class="h-64 mb-2"
                      />
                    </router-link>
                    <div>
                      <router-link
                        :to="`/books/${book.id}`"
                        class="text-lg font-bold text-black hover:text-gray-700 mb-1 block"
                      >
                        {{ book.title }}
                      </router-link>
                      <div class="text-gray-800">{{ book.author }}</div>
                    </div>
                  </div>
                </div>
              </template>
            </ApolloQuery>
            <ApolloQuery
              :query="query"
              :variables="{ featured: true }"
              v-else-if="selectedCategory === 'featured'"
            >
              <template slot-scope="{ result: { data, loading }, isLoading }">
                <div v-if="isLoading">Loading...</div>
                <div v-else class="flex flex-wrap">
                  <div
                    v-for="book of data.booksByFeatured"
                    :key="book.id"
                    class="w-1/3 px-4 mb-12"
                  >
                    <router-link :to="`/books/${book.id}`">
                      <img
                        :src="book.image"
                        alt="Cover image"
                        class="h-64 mb-2"
                      />
                    </router-link>
                    <router-link
                      :to="`/books/${book.id}`"
                      class="text-lg font-bold text-black hover:text-gray-700 mb-1 block"
                      >{{ book.title }}</router-link
                    >
                    <div class="text-gray-800">{{ book.author }}</div>
                  </div>
                </div>
              </template>
            </ApolloQuery>
            <ApolloQuery
              :query="query"
              :variables="{ id: selectedCategory }"
              v-else
            >
              <template slot-scope="{ result: { data, loading }, isLoading }">
                <div v-if="isLoading">Loading...</div>
                <div v-else class="flex flex-wrap">
                  <div
                    v-for="book of data.category.books"
                    :key="book.id"
                    class="w-1/3 px-4 mb-12"
                  >
                    <router-link :to="`/books/${book.id}`">
                      <img
                        :src="book.image"
                        alt="Cover image"
                        class="h-64 mb-2"
                      />
                    </router-link>
                    <router-link
                      :to="`/books/${book.id}`"
                      class="text-lg font-bold text-black hover:text-gray-700 mb-1 block"
                      >{{ book.title }}</router-link
                    >
                    <div class="text-gray-800">{{ book.author }}</div>
                  </div>
                </div>
              </template>
            </ApolloQuery>
          </div>
        </div>
      </div>
    </div>

    <!-- <div v-if="selectedCategory === 'all'">
      <ApolloQuery :query="query">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <div v-else>
            <div v-for="book of data.books" :key="book.id">
              <router-link :to="`/books/${book.id}`"
                >{{ book.id }}{{ book.title }}</router-link
              >
              <div>{{ book.author }}</div>
              <img :src="book.image" alt="Cover image" />
            </div>
          </div>
        </template>
      </ApolloQuery>
    </div>
    <div v-else-if="selectedCategory === 'featured'">
      <ApolloQuery :query="query" :variables="{ featured: true }">
        <template slot-scope="{ result: { data, loading }, isLoading }">
          <div v-if="isLoading">Loading...</div>
          <div v-else>
            <div v-for="book of data.booksByFeatured" :key="book.id">
              <router-link :to="`/books/${book.id}`"
                >{{ book.id }}{{ book.title }}</router-link
              >
              <div>{{ book.author }}</div>
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
              <router-link :to="`/books/${book.id}`"
                >{{ book.id }}{{ book.title }}</router-link
              >
              <div>{{ book.author }}</div>
              <img :src="book.image" alt="Cover image" />
            </div>
          </div>
        </template>
      </ApolloQuery>
    </div> -->
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
