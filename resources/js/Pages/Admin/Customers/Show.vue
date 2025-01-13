<script setup lang="ts">
    import { defineProps, ref, computed } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import domtoimage from 'dom-to-image';
    import { jsPDF } from 'jspdf';

    // Props para la información del usuario
    const props = defineProps({
    customer: {
        type: Object,
        required: true,
    },
    });

    // Control del modal y la vista de la credencial
    const isModalOpen = ref(false);
    const isFrontSide = ref(true);

    const openModal = () => (isModalOpen.value = true);
    const closeModal = () => (isModalOpen.value = false);
    const toggleSide = () => (isFrontSide.value = !isFrontSide.value);

    // Imágenes dinámicas para la credencial
    const frontImage = computed(() => {
    return '/img/credenciales/Customer_Enfrente.jpeg';
    });

    const backImage = computed(() => {
    return '/img/credenciales/Customer_Atras.jpeg';
    });

    const downloadAsImage = async () => {
    const element = document.getElementById('credential-content');
    if (!element) return;

    domtoimage
        .toPng(element, {
        quality: 1,
        width: element.offsetWidth,
        height: element.offsetHeight,
        })
        .then((dataUrl) => {
        const link = document.createElement('a');
        link.href = dataUrl;
        link.download = isFrontSide.value ? 'credencial_frente.png' : 'credencial_atras.png';
        link.click();
        })
        .catch((error) => {
        console.error('Error al renderizar la imagen:', error);
        });
    };

    const downloadAsPDF = async () => {
    const element = document.getElementById('credential-content');
    if (!element) return;

    domtoimage
        .toPng(element, {
        quality: 1,
        width: element.offsetWidth,
        height: element.offsetHeight,
        })
        .then((dataUrl) => {
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgWidth = 210;
        const imgHeight = (element.offsetHeight * imgWidth) / element.offsetWidth;

        pdf.addImage(dataUrl, 'PNG', 0, 0, imgWidth, imgHeight);
        pdf.save(isFrontSide.value ? 'credencial_frente.pdf' : 'credencial_atras.pdf');
        })
        .catch((error) => {
        console.error('Error al renderizar el PDF:', error);
        });
    };
</script>


<template>
    <Head title="Clientes" />
    <AuthenticatedLayout>
        <template #header>
          Clientes
        </template>

        <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg dark:bg-gray-800">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
                Información del Cliente
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre del cliente -->
                <div>
                <p class="text-gray-500 dark:text-gray-400">Nombre:</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ customer.name }}</p>
                </div>

                <!-- Correo Electrónico -->
                <div>
                <p class="text-gray-500 dark:text-gray-400">Correo electrónico:</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ customer.email }}</p>
                </div>

                <!-- Numero de cliente -->
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Número de cliente:</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ customer.numberId }}</p>
                </div>

                <!-- Fraccionamiento -->
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Fraccionamiento:</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ customer.fraccionamiento }}</p>
                </div>

                <!-- Manzana -->
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Manzana:</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ customer.manzana }}</p>
                </div>

                <!-- Lote -->
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Lote:</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ customer.lote }}</p>
                </div>

                <!-- Productos Referencia Bancaria -->
                <!-- <div>
                    <p class="text-gray-500 dark:text-gray-400">Productos - Referencia bancaria:</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ customer.products_reference }}</p>
                </div> -->

                <!-- Referencia Bancaria -->
                <!-- <div>
                    <p class="text-gray-500 dark:text-gray-400">Referencia bancaria:</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ customer.deals_reference }}</p>
                </div> -->

                <!-- Fecha de cierre -->
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Fecha de cierre:</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ new Date(customer.closing_date).toLocaleDateString('es-ES') }}
                    </p>
                </div>

                <!-- Botones -->
                <div class="col-span-1 md:col-span-2 mt-6 flex gap-4">
                <a
                    class="bg-gray-400 text-white py-2 px-4 rounded hover:bg-teal-600"
                    href="/admin/customers"
                >
                    <font-awesome-icon :icon="['fas', 'arrow-rotate-left']" />
                    Volver
                </a>
                <button
                    class="bg-blue-400 text-white py-2 px-4 rounded hover:bg-blue-600"
                    @click="openModal"
                >
                    <font-awesome-icon :icon="['fas', 'address-card']" />
                    Credencial
                </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg relative max-w-md">
                <!-- Cerrar Modal -->
                <button
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl"
                @click="closeModal"
                >
                <font-awesome-icon :icon="['fas', 'times']" />
                </button>

                <div id="credential-content" class="relative bg-gray-100 rounded-lg overflow-hidden">
                <!-- Imagen de la credencial -->
                <img
                    :src="isFrontSide ? frontImage : backImage"
                    alt="Credencial"
                    class="w-full h-auto"
                />

                <!-- Información sobrepuesta -->
                <div v-if="!isFrontSide" class="absolute inset-0 text-gray-600 text-xs font-bold">
                    <p
                        class="absolute text-center w-full"
                        style="top: 27%;"
                        >
                        {{ customer.name || ' ' }}
                    </p>
                    <!-- No. cliente -->
                    <p
                    class="absolute w-full"
                    style="top: 41%; left: 20.5%;"
                    >
                    {{ customer.numberId || ' ' }}
                    </p>

                    <!-- Manzana -->
                    <p
                    class="absolute text-center w-full"
                    style="top: 41%;"
                    >
                    {{ customer.manzana || ' ' }}
                    </p>

                    <!-- Lote -->
                    <p
                    class="absolute w-full"
                    style="top: 41%; left: 69.8%;"
                    >
                    {{ customer.lote || ' ' }}
                    </p>

                    <!-- Fraccionamiento -->
                    <p
                    class="absolute w-full"
                    style="top: 47.7%; left: 27%;"
                    >
                    {{ customer.fraccionamiento || ' ' }}
                    </p>

                    <!-- Fraccionamiento -->
                    <!-- <p
                    class="absolute font-bold text-cyan-800 text-center text-xl w-full"
                    style="top: 10%"
                    >
                    {{ customer.products_reference || ' ' }}
                    </p> -->
                </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-center gap-4 mt-4">
                <button
                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600"
                    @click="toggleSide"
                >
                    <font-awesome-icon :icon="['fas', 'arrow-rotate-left']" />
                    Voltear Credencial
                </button>
                <button
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    @click="downloadAsImage"
                >
                    <font-awesome-icon :icon="['fas', 'image']" />
                    Descargar Imagen
                </button>
                <button
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                    @click="downloadAsPDF"
                >
                    <font-awesome-icon :icon="['fas', 'file-image']" />
                    Descargar PDF
                </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
  </template>

<style>
#credential-content {
    width: 400px; /* Ancho deseado */

    position: relative;
    overflow: hidden; /* Prevenir cortes */
    background-color: white; /* Evitar fondo transparente */
  }
</style>
