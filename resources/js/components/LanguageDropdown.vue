<script setup>
import { ref } from 'vue';

const currentLang = ref('en');

const languages = [
  { code: 'en', name: 'English', flag: 'gb' },
  { code: 'es', name: 'Español', flag: 'es' },
];

function setLanguage(lang) {
  currentLang.value = lang;
  console.log("Language switched to:", lang);
}
</script>

<template>
  <div class="dropdown">
    <button
      class="btn custom-lang-btn dropdown-toggle d-flex align-items-center"
      type="button"
      id="languageDropdown"
      data-bs-toggle="dropdown"
      aria-expanded="false"
    >
      <span class="me-2 d-flex align-items-center">
        <!-- <img
          :src="`https://flagcdn.com/16x12/${languages.find(l => l.code === currentLang).flag}.png`"
          :alt="languages.find(l => l.code === currentLang).name"
          class="me-1"
        /> -->
        {{ languages.find(l => l.code === currentLang).name }}
      </span>
    </button>

    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
      <li
        v-for="lang in languages"
        :key="lang.code"
      >
        <a
          class="dropdown-item d-flex align-items-center"
          href="#"
          @click.prevent="setLanguage(lang.code)"
        >
          <!-- <img
            :src="`https://flagcdn.com/16x12/${lang.flag}.png`"
            :alt="lang.name"
            class="me-2"
          /> -->
          {{ lang.name }}
        </a>
      </li>
    </ul>
  </div>
</template>

<style scoped>
/* Custom orange button */
.custom-lang-btn {
  background-color: #ff5100;
  color: #ececec;
  border: solid 1px #e64800;
  font-weight: 500;
  transition: all 0.3s ease;
  padding-left: 20px;
  padding-right: 20px;
}

.custom-lang-btn:hover,
.custom-lang-btn:focus,
.custom-lang-btn:active {
  background-color: #e64800;
  color: #fff;
}

.dropdown-item img {
  width: 16px;
  height: 12px;
}

.dropdown-menu {
  min-width: 140px;
}
</style>
