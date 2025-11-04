<template>
  <div class="min-h-screen bg-gray-50">
    <Header />
    <main>
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script>
import Header from './Header.vue';
import Footer from './Footer.vue';

export default {
  name: 'MainLayout',
  components: {
    Header,
    Footer,
  },
};
</script>
