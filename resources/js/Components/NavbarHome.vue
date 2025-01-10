<template>
    <nav class="bg-gray-950 shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-32 items-center">
          <!-- Logo -->
          <div class="flex-shrink-0 flex items-center">
            <a href="/">
              <img src="/img/logovivelabajaBlanco.png" alt="Logo" class="h-28" />
            </a>
          </div>

          <!-- Menú principal -->
          <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
            <!-- Dropdown de usuario si está autenticado -->
            <div v-if="isAuthenticated" class="relative flex items-center">
              <button
                @click="toggleDropdown"
                class="text-white hover:bg-gray-700 p-4 rounded-xl text-md font-medium text-xl flex items-center"
              >
                <font-awesome-icon icon="fas fa-user" class="mr-2 text-white" />
                {{ userName }}
                <svg
                  class="ml-2 h-5 w-5"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                  />
                </svg>
              </button>
              <div
                v-if="dropdownOpen"
                class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-xl py-2 z-50"
              >
                <a
                  href="/admin"
                  class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-xl"
                >
                  Panel Administrativo
                </a>
                <button
                  @click="logout"
                  class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-xl"
                >
                  Cerrar sesión
                </button>
              </div>
            </div>

            <!-- Botón de Iniciar sesión si no está autenticado -->
            <a
              v-else
              href="/login"
              class="text-white hover:bg-gray-700 px-3 py-2 rounded-xl text-md font-medium"
            >
              Iniciar Sesión
            </a>
          </div>

          <!-- Menú móvil -->
          <div class="-mr-2 flex items-center sm:hidden">
            <button
              @click="toggleMobileMenu"
              class="bg-gray-700 inline-flex items-center justify-center p-2 rounded-xl text-white hover:text-gray-200 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-sky-600 focus:ring-white"
            >
              <span class="sr-only">Abrir menú</span>
              <svg
                class="h-6 w-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16m-7 6h7"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Menú móvil desplegable -->
      <div
        v-if="mobileMenuOpen"
        class="sm:hidden bg-gray-950 text-white py-4 space-y-2"
      >
        <a
          v-if="isAuthenticated"
          href="/admin"
          class="block px-3 py-2 hover:bg-gray-700 rounded-md"
        >
          Panel Administrativo
        </a>
        <a
          v-if="!isAuthenticated"
          href="/login"
          class="block px-3 py-2 hover:bg-gray-700 rounded-md"
        >
          Iniciar Sesión
        </a>
        <button
          v-if="isAuthenticated"
          @click="logout"
          class="block w-full text-left px-3 py-2 hover:bg-gray-700 rounded-md"
        >
          Cerrar sesión
        </button>
      </div>
    </nav>
  </template>

  <script setup>
  import { ref, computed } from "vue";
  import { usePage } from "@inertiajs/vue3";

  // Variables para dropdown y menú móvil
  const dropdownOpen = ref(false);
  const mobileMenuOpen = ref(false);

  // Obtener información de autenticación desde usePage
  const page = usePage();
  const isAuthenticated = computed(() => page.props.auth?.user !== null);
  const userName = computed(
    () => page.props.auth?.user?.name || "Usuario"
  );

  // Métodos
  const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
  };

  const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
  };

  const logout = () => {
    $inertia.post("/logout");
  };
  </script>

  <style scoped>
  /* Ajustar el dropdown */
  .relative .absolute {
    top: 100%; /* Ajusta para que aparezca debajo del botón */
    margin-top: 0.5rem;
    right: 0;
  }

  /* Mejoras generales */
  .shadow-lg {
    z-index: 10;
  }
  </style>
