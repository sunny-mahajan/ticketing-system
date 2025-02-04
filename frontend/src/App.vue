<template>
  <div class="container mx-auto p-4">
    <MainHeader />
    <main>
      <router-view />
    </main>
  </div>
</template>

<script>
import MainHeader from "./components/common/Header.vue";

export default {
  components: { MainHeader },
};
</script>
