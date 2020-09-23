<template>
  <div class="sm:mx-auto md:mx-auto text-left">
    <router-link :to="`/books/${book.id}`">
      <img :src="book.image" alt="Cover image" class="h-64 mb-2" />
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
</template>
<script>
export default {
  props: ["book"],
};
</script>
