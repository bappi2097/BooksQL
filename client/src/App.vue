<template>
  <div id="app" class="font-sans antialiased text-black">
    <div id="nav" class="bg-purple-500">
      <div class="container flex items-center justify-between py-6">
        <div>
          <a href="/"><img src="./assets/logo.svg" alt="logo" /></a>
        </div>
        <div>
          <router-link to="/" class="text-white hover:text-gray-200"
            >Home</router-link
          >
          <router-link to="/about" class="text-white hover:text-gray-200 pl-6"
            >About</router-link
          >
        </div>
      </div>
    </div>
    <router-view />
    <footer-view />
  </div>
</template>
<script>
import FooterView from "./components/Footer";
export default {
  components: { FooterView },
};
</script>
<style src="./assets/main.css"></style>
