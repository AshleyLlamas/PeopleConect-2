<script setup lang="ts">
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { defineProps, ref, computed } from 'vue';
    import { Head } from '@inertiajs/vue3';
    import domtoimage from 'dom-to-image';
    import { jsPDF } from 'jspdf';

    // Props para la información del usuario
    const props = defineProps({
        user: {
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
    return props.user.puesto === 'ASESOR DE VENTAS'
        ? '/img/credenciales/VeLB_Gafete_Asesor_Enfrente.svg'
        : '/img/credenciales/VeLB_Gafete_Enfrente.svg';
    });

    const backImage = computed(() => {
    return props.user.puesto === 'ASESOR DE VENTAS'
        ? '/img/credenciales/VeLB_Gafete_Asesor_Atras.svg'
        : '/img/credenciales/VeLB_Gafete_Atras.svg';
    });

    // Descargar como imagen
    const downloadAsImage = async () => {
        const element = document.getElementById('credential-content');
        if (!element) return;

        try {
            const dataUrl = await domtoimage.toPng(element, {});
            const link = document.createElement('a');
            link.href = dataUrl;
            link.download = isFrontSide.value ? 'credencial_frente.png' : 'credencial_atras.png';
            link.click();
        } catch (error) {
            console.error('Error al renderizar la imagen:', error);
        }
    };


        // Descargar como PDF
        const downloadAsPDF = async () => {
        const element = document.getElementById('credential-content');
        if (!element) return;

        try {
            const dataUrl = await domtoimage.toPng(element, {});
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgWidth = 210;
            const imgHeight = (element.offsetHeight * imgWidth) / element.offsetWidth;
            pdf.addImage(dataUrl, 'PNG', 0, 0, imgWidth, imgHeight);
            pdf.save(isFrontSide.value ? 'credencial_frente.pdf' : 'credencial_atras.pdf');
        } catch (error) {
            console.error('Error al renderizar el PDF:', error);
        }
    };
</script>

<template>
    <Head title="Usuarios" />
    <AuthenticatedLayout>
        <template #header>
          Usuarios
        </template>

        <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
            <h2 class="text-2xl font-bold text-cyan-800 mb-6">
                Información del Usuario
            </h2>

            <div v-if="user.image" class="pb-4">
                <img
                    :src="`/storage/public/${user.image.url}`"
                    alt="Gafete del usuario"
                    class="w-32 h-32 rounded-full object-cover mx-auto"
                />
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre del Usuario -->
                <div>
                    <p class="text-gray-500">Número de empleado:</p>
                    <p class="text-lg font-semibold text-gray-800">{{ user.número_de_empleado }}</p>
                </div>

                <!-- Nombre del Usuario -->
                <div>
                <p class="text-gray-500">Nombre:</p>
                <p class="text-lg font-semibold text-gray-800">{{ user.name }}</p>
                </div>

                <!-- Correo Electrónico -->
                <div>
                <p class="text-gray-500">Correo Electrónico:</p>
                <p class="text-lg font-semibold text-gray-800">{{ user.email }}</p>
                </div>

                <!-- Puesto -->
                <div>
                <p class="text-gray-500">Puesto:</p>
                <p class="text-lg font-semibold text-gray-800">{{ user.puesto }}</p>
                </div>

                <!-- CURP -->
                <div>
                    <p class="text-gray-500">CURP:</p>
                    <p class="text-lg font-semibold text-gray-800">{{ user.curp }}</p>
                </div>

                <!-- Botones -->
                <div class="col-span-1 md:col-span-2 mt-6 flex gap-4">
                    <a
                        class="bg-gray-400 text-white py-2 px-4 rounded hover:bg-teal-600"
                        href="/admin/users"
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
                    <div v-if="!isFrontSide" class="absolute inset-0 text-xl font-bold">
                        <div v-if="user.puesto === 'ASESOR DE VENTAS'" class="text-teal-600">
                            <p
                                class="absolute text-center w-full"
                                style="top: 53%;"
                                >
                                {{ user.numero_asesor_de_ventas || ' ' }}
                            </p>
                            <!-- Imagen QR -->
                            <img v-if="user.puesto === 'ASESOR DE VENTAS'"
                                :src="`/img/credenciales/qr_vendedores.png`"
                                alt="Gafete del usuario"
                                class="absolute w-64 mx-auto"
                                style="top: 8.1%; left: 18.5%;"
                            />
                        </div>
                        <div v-if="user.puesto != 'ASESOR DE VENTAS'" class="text-cyan-300">
                            <p
                                class="absolute text-center w-full"
                                style="top: 55.5%;"
                            >
                                {{ user.curp || ' ' }}
                            </p>
                        </div>
                    </div>

                    <div v-if="isFrontSide">
                        <div v-if="user.image">
                            <!-- Imagen -->
                            <img v-if="user.puesto === 'ASESOR DE VENTAS'"
                                :src="`/storage/public/${user.image.url}`"
                                alt="Gafete del usuario"
                                class="absolute w-52 rounded-xl"
                                style="top: 20.1%; left: 24%; height:270px;"
                            />
                            <img v-if="user.puesto != 'ASESOR DE VENTAS'"
                                :src="`/storage/public/${user.image.url}`"
                                alt="Gafete del usuario"
                                class="absolute w-52"
                                style="top: 25%; left: 23.9%; height:270px;"
                            />
                        </div>
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
