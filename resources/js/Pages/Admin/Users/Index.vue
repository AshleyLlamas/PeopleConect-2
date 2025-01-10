<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
  users: {
    type: Object,
  },
});

// Cambiar el nombre a `eliminarUsuario` para coincidir con el template
const eliminarUsuario = (id) => {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡No podrás revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      // Realizar la petición para eliminar el usuario
      router.delete(route('admin.users.destroy', id), {
        onSuccess: () => {
          Swal.fire(
            '¡Eliminado!',
            'El usuario ha sido eliminado.',
            'success'
          );
        },
      });
    }
  });
};

// Capturar el mensaje de éxito desde el servidor
const page = usePage();
onMounted(() => {
  if (page.props.flash.success) {
    Swal.fire({
      icon: 'success',
      title: 'Éxito',
      text: page.props.flash.success,
    });
  }
});
</script>

<template>
  <Head title="Usuarios" />

  <AuthenticatedLayout>
    <template #header>
      Usuarios
    </template>

    <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
        <div class="overflow-x-auto w-full">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3">Correo electrónico</th>
                <th class="px-4 py-3">Puesto</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="user in users.data" :key="user.id" class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                  {{ user.name }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ user.email }}
                </td>
                <td class="px-4 py-3 text-sm">
                    {{ user.puesto || "-" }}
                </td>
                <td width="10px">
                  	<!-- Botón para Ver -->
					<a :href="route('admin.users.show', user)" class="flex items-center px-3 mx-1 py-2 text-sm font-medium text-teal-600 bg-teal-100 rounded hover:bg-teal-200 focus:outline-none focus:ring focus:ring-teal-300">
						<font-awesome-icon :icon="['fas', 'eye']" />
					</a>
				</td>
				<!-- <td width="10px">
					<a :href="route('admin.users.edit', user)" class="flex items-center px-3 mx-1 py-2 text-sm font-medium text-yellow-600 bg-yellow-100 rounded hover:bg-yellow-200 focus:outline-none focus:ring focus:ring-yellow-300">
						<font-awesome-icon icon="fas fa-edit" />
					</a>
				</td>
				<td width="10px">
					<button @click="eliminarUsuario(user)" class="flex items-center px-3 mx-1 py-2 text-sm font-medium text-red-600 bg-red-100 rounded hover:bg-red-200 focus:outline-none focus:ring focus:ring-red-300">
						<font-awesome-icon icon="fas fa-trash-alt" />
					</button>
                </td> -->
              </tr>
            </tbody>
          </table>
        </div>
        <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
          <Pagination :links="users.links" />
        </div>
      </div>
  </AuthenticatedLayout>
</template>
